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
            // Book::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "History";
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
            $name = "Econ";
            $id = 2;

            $name2 = "Physics";
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
            $name = "Econ";
            $id = 2;

            $name2 = "Physics";
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
            $name = "Econ";
            $id = 2;

            $test_author = new Author($name, $id);
            $test_author->save();
            $new_name = "Economics";

            //Act
            $test_author->updateAuthor($new_name);

            //Assert
            $this->assertEquals("Economics", $test_author->getName());
        }

        function testDeleteAuthor()
        {
            //Arrange
            $name = "Econ";
            $id = 2;

            $name2 = "Physics";
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
            $name = "Econ";
            $id = 2;

            $name2 = "Physics";
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



    }

?>
