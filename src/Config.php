<?php
namespace Mediashare\Crawler;

/**
 * Config
 * Add more options and edit crawling action.
 */
class Config {
    public $webspider = true; // Crawl all website
    public $verbose = false; // Prompt output progress bar
    public $pathRequires = [];
    public $pathExceptions = [];
    private $modules = [];

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

    public function getPathRequires(): ?array {
        return $this->pathRequires;
    }
    public function setPathRequires(array $requires): self {
        $this->pathRequires = $requires;
        return $this;
    }

    public function getPathExceptions(): ?array {
        return $this->pathExceptions;
    }
    public function setPathExceptions(array $exceptions): self {
        $this->pathExceptions = $exceptions;
        return $this;
    }

    public function getModules() {
        if ($this->modules):
            return $this->modules;
        else:
            return null;
        endif;
    }

    public function setModules($modules): self {
        $this->modules = $modules;
        return $this;
    }
}