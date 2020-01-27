<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
use Mediashare\Crawler\Config;

$config = new Config();
$config->setWebspider(true);
$config->setVerbose(true);
$config->setPathRequires(['/Kernel/']); // Not crawl other path
$config->setPathExceptions(['/CodeSnippet/']); // Not crawl this path

$crawler = new Crawler("https://mediashare.fr", $config);
$crawler->run();
// dump($crawler);