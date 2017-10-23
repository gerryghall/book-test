<?php
namespace BookStore;
/**
 * @package     Book Store
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class Book  implements \ArrayAccess, \JsonSerializable {

    private $isbn;
    protected $title;
    protected $author;
    protected $category = [];
    protected $price;

    /**
     * Book constructor.
     * @param        $isbn
     * @param string $title
     * @param string $author
     * @param string $price
     * @param array  $category
     */
    public function __construct($isbn) {

        if (!preg_match("/^[0-9]{3}[-][0-9]{10}$/i", $isbn)) {
            throw new InvalidIsbnException("Invalid ISBN");
        }
        $this->isbn = $isbn;
    }

    /**
     * @param $object
     * @return Book
     */
    public static function fromObject($object) {

        if (!isset($object->isbn)) {
            throw new InvalidIsbnException("ISBN is not set");
        }

        $book = new self($object->isbn);

        if (isset($object->title)) {
            $book->setTitle($object->title);
        }
        if (isset($object->author)) {
            $book->setAuthor($object->author);
        }
        if (isset($object->price)) {
            $book->setAuthor($object->author);
        }
        if (isset($object->category)) {
            $book->setAuthor($object->author);
        }
        return $book;
    }

    /**
     * @param $isbn
     * @return Book
     */
    public static function fromIsbn($isbn) {
        return new self($isbn);
    }

    /**
     * @return mixed
     */
    public function getTitle() {

        return $this->title;
    }

    /**
     * @param mixed $title
     * @return self
     */
    public function setTitle($title) {

        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor() {

        return $this->author;
    }

    /**
     * @param mixed $author
     * @return self
     */
    public function setAuthor($author) {

        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory() {

        return $this->category;
    }

    /**
     * @param mixed $category
     * @return self
     */
    public function setCategory(array $category) {

        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice() {

        return $this->price;
    }

    /**
     * @param mixed $price
     * @return self
     */
    public function setPrice($price) {

        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsbn() {

        return $this->isbn;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists ( $offset )
    {
        return property_exists( $this, $offset) ;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet ( $offset )
    {
        if( property_exists( $this, $offset) ) {
            return $this->$offset;
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws \Exception
     */
    public function offsetSet ( $offset ,$value )
    {
        throw new \Exception("Operation not permitted use setters instead");
    }
    public function offsetUnset ( $offset )
    {
        throw new \Exception("Operation not permitted use setters instead");
    }

    public function jsonSerialize() {
       $data = array();
       $data['isbn'] = $this->getIsbn();
       $data['title'] = $this->getTitle();
       $data['category'] = $this->getCategory();
       $data['author'] = $this->getAuthor();
       $data['price'] = $this->getPrice();
        return $data;
    }

}