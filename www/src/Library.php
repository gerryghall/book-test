<?php
namespace BookStore;

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class Library implements \JsonSerializable {

    private $books;
    /**
     * a basic list of book's ISBN mapped with the category
     * @var $index
     */
    private $index;

    private $categories = false;

    /**
     * Library constructor.
     */
    public function __construct() {

        $this->books = new \ArrayIterator();
    }

    /**
     * Load book objects into the library, just a helper.
     * @param array $objects
     */
    public function load(Array $objects) {

        foreach ($objects as $object) {
            $book = Book::fromObject($object);
            $this->index[$book->getIsbn()] = $book->getCategory();
            $this->addBook($book);
            $book = null;
        }
    }
    public function books ()
    {
        return $this->books->getArrayCopy();
    }

    public function getCategories() {
        if( $this->categories == false) {
            $this->categories = [];
            foreach ($this->books as $book) {
                $this->categories = array_merge($this->categories, $book->getCategory());
            }
            $this->categories = array_keys( array_flip($this->categories));
        }
        return $this->categories;
    }

    /**
     * books constructor.
     * @param $book
     */

    public function addBook(Book $book) {

        $this->books->append($book);
    }

    public function getBookById($isbn) {
        return  $this->getData("isbn", $isbn);
    }

    public function getBookByTitle($title) {
        return  $this->getData("title", $title, 2);
    }

    public function getBookByAuthor($author) {
        return  $this->getData("author", $author, 2);
    }

    public function getBookByCategory($category) {
        return  $this->getData("category", $category, 1);
    }

    public function jsonSerialize() {
        return $this->books->getArrayCopy();
    }

    protected function getData($property, $value , $type = 0) {
        $books = [];
        $filtered = new BookFilter($this->books, $property, $value, $type);
        foreach ($filtered as $book) {
            $books[] = $book;
        }
        $filtered = null;
        return $books;
    }
}