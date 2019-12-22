<?php
namespace Mediashare\Crawler;

/**
 * Config
 * Add more options and edit crawling action.
 */
class Config {
    public $webspider = true; // Crawl all website
    public $verbose = false; // Prompt output progress bar

    public function getWebspider(): ?bool
    {
        return $this->webspider;
    }

    public function setWebspider(bool $webspider): self
    {
        $this->webspider = $webspider;
        return $this;
    }

    public function getVerbose(): ?bool
    {
        return $this->verbose;
    }

    public function setVerbose(bool $verbose): self
    {
        $this->verbose = $verbose;
        return $this;
    }
}
