<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
use Mediashare\Crawler\Config;

$config = new Config();
$config->setWebspider(true);
$config->setVerbose(true);

$crawler = new Crawler("http://marquand.pro", $config);
$crawler->run();
// dump($crawler);