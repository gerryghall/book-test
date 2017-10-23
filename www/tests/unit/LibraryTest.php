<?php
namespace BookStore\unit;
use BookStore\BookFilter;
use BookStore\Book;
use BookStore\JsonProvider;
use BookStore\Library;

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

final class LibraryTest extends \PHPUnit_Framework_TestCase {

    protected $library;
    protected $iterator;

    public function setUp() {

        $provider = JsonProvider::instance();
        $this->library = $provider->load();

    }

    public function testCanFilter() {

        // For each Book
        foreach ($this->library->books() as $book) {
            // Foreach property / value
            foreach ($book as $property => $value) {
                // we need to deal with category as they are an array
                if (!is_string($value)) {
                    continue;
                }
                // Create instance setting the current property as the filter with it's value.
                $this->assertInstanceOf(
                    BookFilter::class,
                    $filtered = BookFilter::init($this->library, $property, $value));
                $filtered = iterator_to_array($filtered);
                switch ($property) {
                    case 'isbn':
                        $this->assertCount(1, $filtered);
                        $this->assertBooksKeysExist($filtered, $property, $value);
                        break;
                    case 'title':
                        $this->assertCount(1, $filtered);
                        $this->assertBooksKeysExist($filtered, $property, $value);
                        break;
                    case 'author':
                        $this->assertBooksKeysExist($filtered, $property, $value);
                        if($value = 'Robin Nixon') {
                            $this->assertCount(2, $filtered);
                        } else {
                            $this->assertCount(1, $filtered);
                        }
                        break;
                }

            }
        }
    }

    /**
     *
     */
    public function testAddBook () {
        $library = new Library();

        foreach ($this->library->books() as $book) {
            $book = Book::fromObject($book);
            $library->addBook($book);
        }

        foreach ($library->books() as $book) {
            $libIsbn =  $this->library->getBookById($book->getIsbn);
            $newIsdn =  $this->library->getBookById($book->getIsbn);
            $this->assertEquals($libIsbn, $newIsdn);
        }

    }

    /**
     * @param $books
     * @param $property
     * @param $value
     */
    private function assertBooksKeysExist ($books, $property, $value) {
        foreach ($books as $book) {
            $this->assertBookKeysExist($book, $property, $value);
        }
    }

    /**
     * Legacy code is notorious for a variant of manipulations it is common to turn objects into arrays this issue is set properties
     * can be lost :-( so this test is to ensure developers have not been bad and altered the expect scheme or structure ironically
     * by casing too an array.
     * @param $book
     * @param $property
     * @param $value
     */
    private function assertBookKeysExist ($book, $property, $value) {
        $book = (array)$book;
        $this->assertArrayHasKey('isbn',$book, "$property, $value");
        $this->assertArrayHasKey('title',$book, "$property, $value");
        $this->assertArrayHasKey('author',$book, "$property, $value");
        $this->assertArrayHasKey('category',$book, "$property, $value");
        $this->assertArrayHasKey('price',$book, "$property, $value");
    }
}
