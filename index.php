<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
use Mediashare\Crawler\Config;

$config = new Config();
$config->setWebspider(true);
$config->setVerbose(true);

$crawler = new Crawler("https://mediashare.fr", $config);
$crawler->run();
// dump($crawler);