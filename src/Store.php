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
            $GLOBALS['DB']->exec("INSERT INTO store (store_name) VALUES ('{$this->getStoreName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        // function update()
        // {
        //     $GLOBALS['DB']->exec("UPDATE store SET store_name = '{$this->getStoreName()}' WHERE id = {$this->getId()};");
        // }

        // function deleteOne()
        // {
        //     $GLOBALS['DB']->exec("DELETE FROM store WHERE id = {$this->getId()};");
        // }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM store;");
        }

        static function getAll()
        {
            $stores_returned = $GLOBALS['DB']->query("SELECT * FROM store;");
            $stores = array();
            foreach($stores_returned as $store){
                $store_name = $store['store_name'];
                $id = $store['id'];
                $new_store = new Store($store_name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        // static function find($searchId)
        // {
        //     $stores_returned = Store::getAll();
        //     foreach($stores_returned as $store){
        //        if ($searchId == $store->getId()){
        //            return $store;
        //        }
        //     }
        // }
    }
?>
