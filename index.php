<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
$crawler = new Crawler("http://marquand.pro/6/projet");
$crawler->run();
dump($crawler);