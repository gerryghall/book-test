<?php

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace BookStore;

class BookException extends \Exception implements \JsonSerializable {

    protected $title;

    public function jsonSerialize()
    {
        return Error::init($this->getTitle(), $this->getMessage(), $this->getCode());
    }

    /**
     * @return mixed
     */
    public function getTitle() {

        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {

        $this->title = $title;
    }
}