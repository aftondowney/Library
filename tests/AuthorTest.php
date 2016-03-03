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


    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "Stephen King";
            $id = null;
            $test_author = new Author($name, $id);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "John Clancy";
            $id = 2;

            $name2 = "Robert Ludlum";
            $id2 = 3;

            $test_author = new Author($name, $id);
            $test_author->save();
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "John Clancy";
            $id = 2;

            $name2 = "Robert Ludlum";
            $id2 = 3;

            $test_author = new Author($name, $id);
            $test_author->save();
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            Author::deleteAll();

            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateAuthor()
        {
            //Arrange
            $name = "John Clancy";
            $id = 2;

            $test_author = new Author($name, $id);
            $test_author->save();
            $new_name = "Jon Clancy";

            //Act
            $test_author->updateAuthor($new_name);

            //Assert
            $this->assertEquals("Jon Clancy", $test_author->getName());
        }

        function testDeleteAuthor()
        {
            //Arrange
            $name = "John Clancy";
            $id = 2;

            $name2 = "Robert Ludlum";
            $id2 = 3;

            $test_author = new Author($name, $id);
            $test_author->save();
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $test_author->deleteAuthor();

            //Assert
            $this->assertEquals([$test_author2], Author::getAll());
        }

        function testFindAuthor()
        {
            //Arrange
            $name = "John Clancy";
            $id = 2;

            $name2 = "Robert Ludlum";
            $id2 = 3;

            $test_author = new Author($name, $id);
            $test_author->save();
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::findAuthor($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function testAddBook()
        {
            //Arrange
            $name = "John Clancy";
            $id = null;
            $test_author = new Author($name, $id);
            $test_author->save();

            $title = "The Hunt for the Blue October";
            $id = 2;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Rainbow Seven";
            $id2 = 3;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $result = $test_author->addBook($test_book);

            //Assert
            $this->assertEquals( [$test_book], $test_author->getBook());
        }

        function testGetBook()
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
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $result = $test_author->getBook();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

    }

?>
