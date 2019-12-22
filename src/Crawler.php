<?php
namespace Mediashare\Crawler;

use League\CLImate\CLImate;
use Mediashare\Crawler\Config;
use Mediashare\Scraper\Scraper;
use Mediashare\Crawler\Entity\Url;
use Mediashare\Crawler\Entity\Crawl;

/**
 * Crawler
 * Crawl urls from a webpage and provide a DomCrawler with Scraper Library
 */
Class Crawler
{
    public $url;
    public $config;
    public $urls = [];
    public $wait = []; // Urls list not crawled
    function __construct(string $url, ?Config $config) {
        $this->url = $url;
        if (!$config): $config = new Config(); endif; // Init Config if not exist
        $this->config = $config;
    }

    public function run() {
        // Scrape first page for get more urls
        $scraper = $this->scrape($this->url);

        if ($this->config->getWebspider()):
            while (count($this->wait)) { // Process if urls in wait list
                foreach ($this->wait as $url):
                    $scraper = $this->scrape($url);
                endforeach;
            }
        endif;

        unset($this->wait); // Reset variable for output

		return $this;
    }

    public function scrape(string $url): Scraper {
        $scraper = new Scraper($url);
        $scraper->run();
        // Add new urls in the wait list
        foreach ($scraper->webpage->links as $link) {
            if ($link->isInternal && !isset($this->urls[(string) $link])):
                $this->wait[(string) $link] = (string) $link;
            endif;
        }
        $this->urls[(string) $url] = $scraper; // Record Scraper
        unset($this->wait[(string) $url]); // Remove url to the list
        $this->output($url); // Output

        return $scraper;
    }
    
    private function output(string $url) {
        if ($this->config->getVerbose()) {
            $climate = new CLImate();
            $counter = count($this->urls);
            $max_counter = $counter + \count($this->wait);
            $message = "(".$counter."/".$max_counter.") [".$url."]"; 
            $pourcent = ($counter/$max_counter) * 100;
            if ($pourcent >= 90):
                $climate->green();
            elseif ($pourcent >= 75):
                $climate->lightGreen();
            elseif ($pourcent >= 50):
                $climate->blue();
            else:
                $climate->cyan();        
            endif;
            $progress = $climate->progress()->total($max_counter);        
            $progress->advance($counter, $message);
        }
    }
}
