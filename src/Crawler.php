<?php
namespace Mediashare\Crawler;

use Mediashare\Scraper\Scraper;
use Mediashare\Crawler\Entity\Url;
use Mediashare\Crawler\Entity\Crawl;

/**
 * Crawler
 * Crawl all urls of a webpage and provide a DomCrawler with Scraper Library
 * @return Result
 */
Class Crawler
{
    public $url;
    public $urls = [];
    public $crawled = [];
    function __construct(string $url) {
        $this->url = $url;
    }

    public function run() {
        // Scrape first page for get more urls
        $scraper = $this->scrape($this->url);
        $this->crawled[$this->url] = $scraper;

        while (count($this->urls)) {
            foreach ($this->urls as $url) {
                $scraper = $this->scrape($url);
                $this->crawled[(string) $url] = $scraper;
                unset($this->urls[(string) $url]);
            }
        }        
		return $this;
    }

    public function scrape(string $url): Scraper {
        $scraper = new Scraper($url);
        $scraper->run();
        
        // Add new urls
        foreach ($scraper->webpage->links as $link) {
            if ($link->isInternal && !isset($this->crawled[(string) $link])):
                $this->urls[(string) $link] = (string) $link;
            endif;
        }

        return $scraper;
    }
}
