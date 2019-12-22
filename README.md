# Crawler
:dizzy: Crawl all the urls of a webpage and provide a DomCrawler.

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