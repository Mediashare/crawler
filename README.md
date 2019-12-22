# Crawler
:dizzy: Crawl urls from a webpage and provide a DomCrawler with Scraper Library

## Installation
```bash
composer require mediashare/crawler
```
## Usage
```php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
$crawler = new Crawler("http://marquand.pro");
$crawler->run();
dump($crawler);
```