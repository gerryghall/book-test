<?php
namespace BookStore;
use BookStore\JsonProvider;
use BookStore\Library;
use BookStore\Book;
use Silex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once ( dirname(__FILE__) .  '/config.php' );

/**
 * Main entry point for BookStroe API
 * @package     BookStore
 * @copyright   2017 Gerry G Hall (gerryghall.co.uk)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$app = new Silex\Application();

// Root.
$app->get('/api/', function () {

    return "Welcome to the Book Store <br>
    /api/books/<br>
    /api/books/category/{category}/<br>
    /api/books/author/{author}/<br>
    /api/books/create/ <br>
    
    ";
});

$app->get('/api/books/author/', function () {

    return "Authors<br>
   Filter books by Author filters by text like searching. <br>
   Match : 'Christopher Negus' <br>
                Christopher <br>
                Negus <br>
    /api/books/author/{author}/<br>    
    ";
});

$provider = JsonProvider::instance();
$library = $provider::load();

// Full library.
$app->get('/api/books/', function () use ($app, $library) {
    return $app->json($library);
});


// Categories.
$app->get('/api/books/category/', function () use ($app, $library) {
    return "Categories<br>
   
    /api/books/category/{category}/<br>    
    ";
});

// Categories.
$app->get('/api/books/categories/', function () use ($app, $library) {

    return $app->json($library->getCategories());
});

$app->get('/api/books/category/{category}/', function ($category) use ($app, $library) {

    return $app->json($library->getBookByCategory($category));

});


$app->get('/api/books/author/{author}/', function ($author) use ($app, $library) {

    return $app->json($library->getBookByAuthor($author));

});

$app->get('/api/books/author/{author}/category/{category}/', function ($author, $category) use ($app, $library) {

    $lib = $library->getBookByAuthor($author);
    return $app->json();

});

$app->post('/api/books/create/', function (Request $request) use ($app, $library) {

    $data = $request->request->all();
    try {

        $book = Book::fromObject((object)$data);
        $data = null;
        $library->addBook($book);
        JsonProvider::save($library);
        $response = $book;
        $book = null;
    } catch (\Exception $e) {
        if ($e instanceof InvalidIsbnException ) {
            $response = Error::init($e->getTitle(), $e->getMessage(), $e->getCode());
        } else {
            $response = Error::init("General Error", $e->getMessage(), $e->getCode());
        }
        return $app->json($response, 400);
    }


    return $app->json($response, 201);
});


$app->run();




