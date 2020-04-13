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
    function __construct(string $url, ?Config $config = null) {
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
		return $this;
    }

    /**
     * Get DomCrawler & more data from the webpage
     *
     * @param string $url
     * @return Scraper
     */
    public function scrape(string $url): Scraper {
        $scraper = new Scraper($url);
        $scraper->run();
        // Add new urls in the wait list
        $this->newUrls($scraper);
        $this->urls[(string) $url] = $scraper; // Record Scraper
        unset($this->wait[(string) $url]); // Remove url to the list
        $this->progressBar($url); // Output ProgressBar
        // Modules
        $modules = $this->modules($scraper);
        $this->modules[$url] = $modules;
        return $scraper;
    }

    private function modules(Scraper $scraper) {
        $modules = $this->config->getModules();
        if ($modules):
            $modules = $this->config->getModules()->run($scraper);
            foreach ($modules as $moduleName => $result):
                $results[$moduleName] = $result;
            endforeach;
            return $results;
        else:
            return null;
        endif;

    }

    private function newUrls($scraper) {
        $exceptions = $this->config->getPathExceptions();
        $requires = $this->config->getPathRequires();
        foreach ($scraper->webpage->links as $link) {
            $crawl = true;
            // Check path Requires & path Exceptions
            if (!empty($exceptions)):
                foreach ($exceptions as $exception) {
                    if (\strpos((string) $link, $exception) !== false):
                        $crawl = false;
                    endif;
                }
            endif;
            if (!empty($requires)):
                $crawl = false;
                foreach ($requires as $require) {
                    if (\strpos((string) $link, $require) !== false):
                        $crawl = true;
                    endif;
                }
            endif;

            // Check if is internal link & if not already in queue
            if ($crawl):
                if ($link->isInternal && !isset($this->urls[(string) $link])):
                    $this->wait[(string) $link] = (string) $link;
                endif;
            endif;
        }
    }
    
    /**
     * Output with progress bar
     *
     * @param string $url
     * @return progressBar
     */
    private function progressBar(string $url) {
        if ($this->config->getVerbose()) {
            $climate = new CLImate();
            $counter = count($this->urls);
            $max_counter = 1;
            if ($this->config->getWebspider() && \count($this->wait) > 0):
                $max_counter = $counter + \count($this->wait);
            endif;
            $message = "(".$counter."/".$max_counter.") [".$url."]"; 
            $pourcent = ($counter/$max_counter) * 100;
            if ($pourcent >= 90):
                $climate->lightGreen();
                elseif ($pourcent >= 75):
                    $climate->green();
            elseif ($pourcent >= 50):
                $climate->cyan();
            else:
                $climate->blue();
            endif;
            $progress = $climate->progress()->total($max_counter);        
            $progress->advance($counter, $message);
        }
    }
}