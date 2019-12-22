# Crawler
:dizzy: Crawl urls from a webpage and provide a DomCrawler with Scraper Library

## Installation
```bash
composer require mediashare/crawler
```
## Usage
```php
<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;

$crawler = new Crawler("http://marquand.pro");
$crawler->run();
dump($crawler);
```
##### With Config
```php
<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
use Mediashare\Crawler\Config;

$config = new Config();
$config->setWebspider(true); // All website crawling
$config->setVerbose(true); // Prompt progress bar

$crawler = new Crawler("http://marquand.pro", $config);
$crawler->run();
dump($crawler);
```