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
        protected function tearDown()
        {
            Brand::deleteAll();
        }

        function testSetBrandName()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->setbrandName("doc martens");
            $result = $new_brand->getbrandName();
            $this->assertEquals("doc martens", $result);
        }

        function testGetBrandName()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);

            $result = $new_brand->getbrandName();

            $this->assertEquals("dr.martens", $result);
        }

        function testGetId()
        {
            $brand_name = "dr.martens";
            $id = 1;
            $new_brand = new Brand($brand_name, $id);

            $result = $new_brand->getId();

            $this->assertEquals(1, $result);

        }

        function testSave()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);

            $new_brand->save();
            $result = Brand::getAll();

            $this->assertEquals($new_brand, $result[0]);
        }

        function testUpdate()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->save();
            $new_brand->setBrandName("doc martens");
            $new_brand->update();

            $result = Brand::getAll();

            $this->assertEquals($new_brand, $result[0]);
        }

        function testGetAll()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->save();

            $brand_name2 = "adidas";
            $new_brand2 = new Brand($brand_name);
            $new_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$new_brand, $new_brand2], $result);
        }

        function testDeleteAll()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->save();

            $brand_name2 = "adidas";
            $new_brand2 = new Brand($brand_name);
            $new_brand2->save();

            Brand::deleteAll();
            $result = Brand::getAll();

            $this->assertEquals([], $result);
        }

        function testDeleteOne()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->save();

            $brand_name2 = "adidas";
            $new_brand2 = new Brand($brand_name);
            $new_brand2->save();

            $new_brand->deleteOne();

            $result = Brand::getAll();

            $this->assertEquals($new_brand2, $result[0]);
        }

        function testFind()
        {
            $brand_name = "dr.martens";
            $new_brand = new Brand($brand_name);
            $new_brand->save();

            $brand_name2 = "adidas";
            $new_brand2 = new Brand($brand_name);
            $new_brand2->save();

            $result = Brand::find($new_brand->getId());

            $this->assertEquals($new_brand, $result);
        }

    }
?>
