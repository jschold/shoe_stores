<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/store.php";
    require_once "src/brand.php";

    $server = 'mysql:host=localhost;dbname=shoe_stores_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testSetStoreName()
        {
            $store_name = "Beacon's Closet";
            $new_store = new Store($store_name);
            $new_store->setStoreName("Buffalo Exchange");
            $result = $new_store->getStoreName();
            $this->assertEquals("Buffalo Exchange", $result);
        }

        function testGetStoreName()
        {
            $store_name = "Beacon's Closet";
            $new_store = new Store($store_name);

            $result = $new_store->getStoreName();

            $this->assertEquals("Beacon's Closet", $result);
        }

        function testGetId()
        {
            $store_name = "Beacon's Closet";
            $id = 1;
            $new_store = new Store($store_name, $id);

            $result = $new_store->getId();

            $this->assertEquals(1, $result);
        }

        function testGetAll()
        {
            $store_name = "Beacon's Closet";
            $new_store = new Store($store_name);
            $new_store->save();

            $store_name2 = "Buffalo Exchange";
            $new_store2 = new Store($store_name);
            $new_store2->save();

            $result = Store::getAll();
            var_dump($result);

            $this->assertEquals([$new_store, $new_store2], $result);
        }

        function testSave()
        {
            $store_name = "Beacon's Closet";
            $new_store = new Store($store_name);

            $new_store->save();
            $result = Store::getAll();

            $this->assertEquals($new_store, $result[0]);
        }

    }
?>
