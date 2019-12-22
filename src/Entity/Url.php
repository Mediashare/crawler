<?php
namespace Mediashare\Crawler\Entity;

use Exception;

Class Url
{
    public $url;
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * Check if $this->url is url valid.
     *
     * @return boolean
     */
    public function checkUrl(): bool {
        if (filter_var($this->url, FILTER_VALIDATE_URL)) { 
            return true;
        } else {
            throw new Exception('Url is not valid!');
            return false;
        }
    }
}
