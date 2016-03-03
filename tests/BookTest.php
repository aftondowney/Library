<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";


    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $title = "Stephen King";
            $id = null;
            $test_book = new Book($title, $id);
            $test_book->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $title = "John Clancy";
            $id = 2;

            $title2 = "Robert Ludlum";
            $id2 = 3;

            $test_book = new Book($title, $id);
            $test_book->save();
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $title = "John Clancy";
            $id = 2;

            $title2 = "Robert Ludlum";
            $id2 = 3;

            $test_book = new Book($title, $id);
            $test_book->save();
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            Book::deleteAll();

            //Assert
            $result = Book::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateBook()
        {
            //Arrange
            $title = "John Clancy";
            $id = 2;

            $test_book = new Book($title, $id);
            $test_book->save();
            $new_title = "Jon Clancy";

            //Act
            $test_book->updateBook($new_title);

            //Assert
            $this->assertEquals("Jon Clancy", $test_book->getTitle());
        }

        function testDeleteBook()
        {
            //Arrange
            $title = "John Clancy";
            $id = 2;

            $title2 = "Robert Ludlum";
            $id2 = 3;

            $test_book = new Book($title, $id);
            $test_book->save();
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $test_book->deleteBook();

            //Assert
            $this->assertEquals([$test_book2], Book::getAll());
        }

        function testFindBook()
        {
            //Arrange
            $title = "John Clancy";
            $id = 2;

            $title2 = "Robert Ludlum";
            $id2 = 3;

            $test_book = new Book($title, $id);
            $test_book->save();
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $result = Book::findBook($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function testAddAuthor()
        {
            //Arrange
            $name = "John Clancy";
            $id = null;
            $test_author = new Author($name, $id);
            $test_author->save();

            $title = "The Hunt for the Blue October";
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Rainbow Seven";
            $test_book2 = new Book($title2, $id);
            $test_book2->save();
            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $this->assertEquals([$test_author], $test_book->getAuthor());
        }

        function testGetAuthor()
        {
            //Arrange
            $name = "John Clancy";
            $id = null;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Robert Ludlum";
            $test_author2 = new Author($name2, $id);
            $test_author2->save();

            $title = "The Hunt for the Blue October";
            $test_book = new Book($title, $id);
            $test_book->save();


            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //Assert
            $this->assertEquals([$test_author, $test_author2], $test_book->getAuthor());
        }

    }

?>
