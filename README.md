# Crawler
:dizzy: Crawl urls from a webpage and provide a DomCrawler with [Scraper Library](https://github.com/Mediashare/scraper).
### DomCrawler
Scraper use DomCrawler library. This is symfony component for DOM navigation for HTML and XML documents. You can retrieve [Documentation Here](https://symfony.com/doc/current/components/dom_crawler.html#usage).

## Installation
```bash
composer require mediashare/crawler
```
## Usage
```php
<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;

$crawler = new Crawler("https://mediashare.fr");
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
$config->setPathRequires(['/Kernel/']); // Not crawl other path
$config->setPathExceptions(['/CodeSnippet/']); // Not crawl this path

$crawler = new Crawler("https://mediashare.fr", $config);
$crawler->run();
dump($crawler);
```
