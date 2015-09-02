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
            $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update()
        {
            $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$this->getBrandName()}' WHERE id = {$this->getId()};");
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores. * FROM brands
                                    JOIN stores_brands ON (brand.id = stores_brands.brand_id)
                                    JOIN stores on (stores_brands.store_id = store.id)
                                    WHERE brand.id = {$this->getId()};");
            $stores = array();
            foreach($returned_stores as $store)
            {
                $store_name = $store['store_name'];
                $id = $store['id'];
                array_push($stores, $new_store);
            }
            return $stores;
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function getAll()
        {
            $brands_returned = $GLOBALS['DB']->query("SELECT * FROM brands;");
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
