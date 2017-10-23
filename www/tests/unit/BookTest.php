<?php
namespace BookStore\unit;
use BookStore\Book;
/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

final class BookTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return array of invalid value for repo creations parameter
     */
    public function canBeCreatedFromIsbnProvider() {

        return array (
            array ("978-1491918661"), array ("978-0596804848"), array ("978-1118999875"), array ("978-0596517748"),
        );
    }

    /**
     * @param $check
     * @return mixed
     * @dataProvider canBeCreatedFromIsbnProvider
     */
    public function testCanBeCreatedFromIsbn($check) {

        $this->assertInstanceOf(Book::class, Book::fromIsbn($check));

    }

    /**
     * @return array of invalid value for repo creations parameter
     */
    public function testInvalidIsbnProvider() {

        $random = substr("1234567890", mt_rand(0, 50), 1) . substr(md5(time()), 1);

        return array (
            array ('', 'BookStore\InvalidIsbnException'),
            array ("\t", 'BookStore\InvalidIsbnException'),
            array ("\n", 'BookStore\InvalidIsbnException'),
            array (' ', 'BookStore\InvalidIsbnException'),
            array ("78-149191866", 'BookStore\InvalidIsbnException'),
            array ('nan', 'BookStore\InvalidIsbnException'),
            array ($random, 'BookStore\InvalidIsbnException'),

        );
    }

    /**
     * @param $check
     * @param $expectation
     * @return mixed
     * @expectedException \InvalidArgumentException
     * @dataProvider testInvalidIsbnProvider
     */
    public function testInvalidIsbn($check, $expectation) {

        $this->setExpectedException($expectation);
        Book::fromIsbn($check);
    }

    public function canAddPropertiesProvider() {

        return array (
            [
                '978-1491918661', 'Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5', 'Robin   Nixon',
                ['PHP', 'Javascript'], 9.99
            ], [
                "978-0596804848", 'Ubuntu: Up and Running: A Power User\'s Desktop Guide', 'Robin   Nixon', ['Linux'], 12.99
            ], [
                "978-1118999875", 'Linux   Bible', 'Christopher Negus', ['Linux'], 19.99
            ], [
                "978-1118999875", 'JavaScript: The Good Parts', 'Douglas Crockford', ['Javascript'], 8.99
            ]
        );
    }

    /**
     * @param $check
     * @return mixed
     * @dataProvider canBeCreatedFromIsbnProvider
     */
    public function testCanAddProperties($props) {

        $book = new Book($props);
        $this->assertInstanceOf(Book::class, $book);
        $this->assertArrayHasKey('title', $book);
        $this->assertArrayHasKey('category', $book);
        $this->assertArrayHasKey('price', $book);
    }

    public function manipulatePropertiesProvider() {

        return array (
            [
                'title', 'Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5',
            ], [
                "author", 'Robin   Nixon',
            ], [
                "category", ['Linux'],
            ], [
                "price", 8.99
            ]
        );
    }

    /**
     * To allow for faster access to a object implements \ArrayAccess but is it read only
     * Developers need to uses the settings for manipulation.
     * @param $check
     * @return mixed
     * @dataProvider canBeCreatedFromIsbnProvider
     */
    public function testCanNotArrayManipulateProperties($props) {

        $expectation = 'Exception';

        $book = new Book($props);

        $this->assertInstanceOf(Book::class, $book);

        $this->setExpectedException($expectation);
        $book['title'] = "foo";

        $this->setExpectedException($expectation);
        $book['author'] = "foo";

        $this->setExpectedException($expectation);
        $book['category'] = [];

        $this->setExpectedException($expectation);
        $book['price'] = 7.50;
    }

}
