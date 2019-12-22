<?php
require 'vendor/autoload.php';

use Mediashare\Crawler\Crawler;
$crawler = new Crawler("http://slote.me");
$crawler->run();
dump($crawler);