<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
  	Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->post("/authors", function() use ($app) {
        $name = $_POST['name'];
        $new_author = new Author($name);
        $new_author->save();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->get("/author/{id}", function($id) use ($app) {
        $author = Author::findAuthor($id);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author -> getBook(), 'all_books' => Book::getAll()));
    });




      return $app;


?>
