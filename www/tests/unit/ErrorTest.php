<?php

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace BookStore\unit;

use BookStore\Error;

class ErrorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return array of valid errors
     */
    public function canCreateErrorProvider() {

        $random = substr("", mt_rand(0, 50), 1) . substr(md5(time()), 1);

        return array (
            array ('title1', 'BookStore1', 0),
            array ("title2", 'BookStore2', 1),
            array ("title3", 'BookStore3', 2),
            array ('title4', 'BookStore4', 3),
            array ("title5", 'BookStore5', 4),
            array ('title6', '$random', 5),
        );
    }


    /**
     *  @dataProvider canCreateErrorProvider
     */
    public function testCanCreateError($title, $description, $code) {

        $this->assertInstanceOf(Error::class, Error::init($title, $description, $code));
    }

}
