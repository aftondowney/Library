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

$app['debug'] = true;

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    //view/update/delete routes for Author
    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll(), 'form' => false));
    });

    $app->post("/authors", function() use ($app) {
        $name = $_POST['name'];
        $new_author = new Author($name);
        $new_author->save();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll(), 'form' => false));
    });

    $app->get("/author/{id}", function($id) use ($app) {
        $author = Author::findAuthor($id);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author -> getBook(), 'all_books' => Book::getAll()));
    });

    $app->get("/author/{id}/edit", function($id) use ($app) {
        $author = Author::findAuthor($id);
        return $app['twig']->render('authors.html.twig', array('author' => $author, 'authors' => Author::getAll(), 'form' => true));
    });

    $app->patch("/authors/updated", function() use ($app) {
        $author_to_edit = Author::findAuthor($_POST['current_authorId']);
        $author_to_edit->updateAuthor($_POST['name']);
        return $app['twig']->render('authors.html.twig', array('author' => $author_to_edit, 'authors' => Author::getAll(), 'form' => false));
    });

    $app->delete('/author/{id}/delete', function($id) use ($app) {
        $author = Author::findAuthor($id);
        $author->deleteAuthor();
        return $app['twig']->render('authors.html.twig', array('author' => $author, 'authors' => Author::getAll(), 'form' => false));
    });

    $app->post("/add_books", function() use ($app) {
        $author = Author::findAuthor($_POST['author_id']);
        $book = Book::findBook($_POST['book_id']);
        $author->addBook($book);
        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBook(), 'all_books' => Book::getAll()));
      });

        //view/update/delete routes for Book
    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll(), 'form' => false));
    });

    $app->post("/books", function() use ($app) {
        $title = $_POST['title'];
        $new_book = new Book($title);
        $new_book->save();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll(), 'form' => false));
    });

    $app->get("/book/{id}", function($id) use ($app) {
        $book = Book::findBook($id);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => $book -> getAuthor(), 'all_authors' => Author::getAll()));
    });

    $app->get("/book/{id}/edit", function($id) use ($app) {
        $book = Book::findBook($id);
        return $app['twig']->render('books.html.twig', array('book' => $book, 'books' => Book::getAll(), 'form' => true));
    });

    $app->patch("/books/updated", function() use ($app) {
        $book_to_edit = Book::findBook($_POST['current_bookId']);
        $book_to_edit->updateBook($_POST['title']);
        return $app['twig']->render('books.html.twig', array('book' => $book_to_edit, 'books' => Book::getAll(), 'form' => false));
    });

    $app->delete('/book/{id}/delete', function($id) use ($app) {
        $book = Book::findBook($id);
        $book->deleteBook();
        return $app['twig']->render('books.html.twig', array('book' => $book, 'books' => Book::getAll(), 'form' => false));
    });




      return $app;


?>
