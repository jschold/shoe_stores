<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/brand.php";

    $server = 'mysql:host=localhost;dbname=shoe_stores_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Brand::deleteAll();
        // }

        function testSetBrandName()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->setbrandName("doc martens");
            $result = $new_brand->getbrandName();
            $this->assertEquals("doc martens", $result);
        }
    }
?>
