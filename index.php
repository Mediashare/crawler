<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
$crawler = new Crawler("http://marquand.pro");
$crawler->run();
dump($crawler);