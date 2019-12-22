<?php
namespace Mediashare\Crawler;

use Mediashare\Scraper\Scraper;
use Mediashare\Crawler\Entity\Url;

/**
 * Crawler
 * Crawl all urls of a webpage and provide a DomCrawler with Scraper Library
 * @return Result
 */
Class Crawler
{
    public $url;
    public $urls = [];
    function __construct(string $url) {
        $this->url = $url;
    }

    public function run() {
        // First Scraping original url
        $scraper = new Scraper($this->url);
        $scraper->run();
        $this->urls[$this->url] = $scraper;
        
        // Scrape another url founded in original url
        $urls = (array) $scraper->webpage->links;
        foreach ($urls as $url) {
            if ($url->isInternal): // Crawl internal url
                $scraper = new Scraper($url);
                $scraper->run();
                $this->urls[(string) $url] = $scraper;        
            endif;
        }
		return $this;
    }
}
