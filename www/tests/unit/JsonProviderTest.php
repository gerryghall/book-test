<?php

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace BookStore\unit;

use BookStore\JsonProvider;
use BookStore\Library;

class JsonProviderTest extends \PHPUnit_Framework_TestCase {

    /**
     * Test if we can create a json provider and if we cam make sure it returns a library object
     */
    public function testCanLaodFile() {
        $provider = JsonProvider::instance();
        $this->assertInstanceOf(JsonProvider::class, $provider);
        $libary = $provider::load();
        $this->assertInstanceOf(Library::class, $libary);
    }
}
