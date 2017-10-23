<?php

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace BookStore;

class Error {
    public $title;
    public $description;
    public $errorCode;

    public static function init($title, $description, $errorCode) {
        $me = new self();
        $me->title = $title;
        $me->description = $description;
        $me->errorCode = $errorCode;
        return $me;

    }
}