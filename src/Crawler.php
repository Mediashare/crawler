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
    public $wait = [];
    public $urls = []; // Urls
    function __construct(string $url) {
        $this->url = $url;
    }

    public function run() {
        // Scrape first page for get more urls
        $scraper = $this->scrape($this->url);
        $this->urls[$this->url] = $scraper;

        while (count($this->wait)) {
            foreach ($this->wait as $url) {
                $scraper = $this->scrape($url);
                $this->urls[(string) $url] = $scraper;
                unset($this->wait[(string) $url]);
            }
        }
        unset($this->wait);
		return $this;
    }

    public function scrape(string $url): Scraper {
        $scraper = new Scraper($url);
        $scraper->run();
        // Add new urls
        foreach ($scraper->webpage->links as $link) {
            if ($link->isInternal && !isset($this->urls[(string) $link])):
                $this->wait[(string) $link] = (string) $link;
            endif;
        }

        return $scraper;
    }
}
