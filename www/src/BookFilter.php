<?php
namespace BookStore;

/**
 * @package
 * @subpackage
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class BookFilter extends \FilterIterator {

    protected $filter;
    protected $value;
    protected $type;

    /**
     * BookFilter constructor.
     * @param \Iterator $it
     * @param           $filter
     * @param           $value
     * @param int       $type
     */
    public function __construct(\Iterator $it, $filter, $value, $type = 0) {

        parent::__construct($it);

        $this->filter = $filter;
        $this->value = $value;
        $this->type = $type;
    }

    public static function init(\Iterator $it, $filter, $value, $type = 0)
    {
        return new self($it, $filter, $value, $type);
    }
    /**
     * The accept method is required, as BookFilter
     * extends FilterIterator with abstract method accept().
     * @access  public
     * @accept  Only allow values that are not set the a requested $value
     * @return  bool
     */
    public function accept() {
        $object = $this->getInnerIterator()->current();
        switch ($this->type) {
            case 0 : // String like for like.


                if (strcasecmp($object[ $this->filter ], $this->value) == 0) {

                    return true;
                }

                break;

            case 1 : // Find array vales or string value in array.

                if (is_array($this->value))
                {
                    if (!empty(array_intersect($object[ $this->filter ], $this->value))) {
                        return true;
                    }
                } else {
                    if (in_array($this->value, $object[ $this->filter ])) {
                        return true;
                    }
                }

                break;

            case 2 : // Word find.
                if (stripos($object[ $this->filter ], $this->value) !== false) {
                    return true;
                }
                break;
        }
        return false;
    }
}