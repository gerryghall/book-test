<?php
namespace BookStore;
use BookStore\Library;
use BookStore\Book;

/**
 *  Simple Json Data provider.
 * @package     BookStore
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once ( dirname(dirname(__FILE__)) .  '/config.php' );

class JsonProvider {
    protected static $file;
    private static $instance;

    private function __construct() {
        static::$file = dirname(dirname(dirname(__FILE__))) . "/data/books.json";
    }

    public final static function instance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public final static function reset () {
        $library = new Library();

        $book = Book::fromIsbn('978-1491918661')
                    ->setAuthor('Robin Nixon')
                    ->setCategory(['PHP','Javascript'])
                    ->setTitle('Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5')
                    ->setPrice('9.99');

        $library->addBook($book);

        $book = Book::fromIsbn('978-0596804848')
                    ->setAuthor('Robin Nixon')
                    ->setCategory(['Linux'])
                    ->setTitle('Ubuntu: Up and Running: A Power User\'s Desktop Guide')
                    ->setPrice('12.99');

        $library->addBook($book);

        $book = Book::fromIsbn('978-1118999875')
                    ->setAuthor('Christopher Negus')
                    ->setCategory(['Linux'])
                    ->setTitle('Linux Bible')
                    ->setPrice('19.99');

        $library->addBook($book);

        $book = Book::fromIsbn('978-0596517748')
                    ->setAuthor('Douglas Crockford')
                    ->setCategory(['Javascript'])
                    ->setTitle('JavaScript: The Good Parts')
                    ->setPrice('8.99');

        $library->addBook($book);
        static::save($library);
    }

    public final static function save (Library $library) {
        file_put_contents(static::$file, serialize($library));
    }

    public final static function load () {
        $data = file_get_contents(static::$file);
        $library = unserialize($data);
        return $library;
    }
}