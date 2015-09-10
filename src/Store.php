<?php

    class Store
    {
        private $store_name;
        private $id;

        function __construct($store_name, $id = null)
        {
            $this->store_name = $store_name;
            $this->id = $id;
        }

        function setStoreName($new_store_name)
        {
            $this->store_name = $new_store_name;
        }

        function getStoreName()
        {
            return $this->store_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
          $test = $this->getStoreName();
            $GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update()
        {
            $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$this->getStoreName()}' WHERE id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
        }

        function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                                                            JOIN brands_stores on (stores.id = brands_stores.store_id)
                                                            JOIN brands on (brands_stores.brand_id = brands.id)
                                                        WHERE stores.id = {$this->getId()};");
            $brands = array();
            foreach($returned_brands as $brand)
            {
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores (store_id, brand_id) VALUES ({$this->getId()}, {brand->getId()});");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function getAll()
        {
            $stores_returned = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($stores_returned as $store) {
                $store_name = $store['store_name'];
                $id = $store['id'];
                $new_store = new Store($store_name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function find($searchId)
        {
            $stores_returned = Store::getAll();
            foreach($stores_returned as $store){
               if ($searchId == $store->getId()){
                   return $store;
               }
            }
        }
    }
?>
