<?php

    class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        function setBrandName($new_brand_name)
        {
            $this->brand_name = $new_brand_name;
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brand (brand_name) VALUES ('{$this->getBrandName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update()
        {
            $GLOBALS['DB']->exec("UPDATE brand SET brand_name = '{$this->getBrandName()}' WHERE id = {$this->getId()};");
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM brand WHERE id = {$this->getId()};");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT store. * FROM brand
                                    JOIN stores_brands ON (brand.id = stores_brands.brand_id)
                                    JOIN store on (stores_brands.store_id = store.id)
                                    WHERE brand.id = {$this->getId()};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brand;");
        }

        static function getAll()
        {
            $brands_returned = $GLOBALS['DB']->query("SELECT * FROM brand;");
            $brands = array();
            foreach($brands_returned as $brand){
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function find($searchId)
        {
            $brands_returned = Brand::getAll();
            foreach($brands_returned as $brand){
               if ($searchId == $brand->getId()){
                   return $brand;
               }
            }
        }
    }
?>
