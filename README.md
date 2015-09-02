# _Shoe Stores_

##### _An app where users can add and view stores and shoes sold in the stores. _

#### By _**Jenna Navratil**_

## Description

_This app allows users to create and add shoe brands that a store carries. Many shoe stores can carry many brands, and vice versa. A user can view a single store to see what brands it carries, and add a brand to that store. A user can view a single brand to see what stores carry it, and add a store to that brand. Stores can be created, viewed, updated, and deleted. Shoe brands can only be created and viewed._

## Setup

Clone the repository. Run the command $composer install in the top level of the cloned directory. Open a PHP server in the web folder of the top level. For a mac, run the following command in your terminal:

php -S localhost:8000. Then open your web browser of choice to localhost:8000.

Start mysql server and adjust ports/root directory. Start Apache server. Open PHPmyAdmin and import the database file.

## Technologies Used

HTML
CSS
PHP
PHPUnit
Silex
Twig
MySql
Bootstrap
Symfony
PhpMyAdmin

### Legal


Copyright (c) 2015 **_Jenna Navratil_**

This software is licensed under the MIT license.

## MySql Commands
SELECT DATABASE();
CREATE DATABASE shoe_stores;
USE shoe_stores;
CREATE TABLE store(store_name VARCHAR(255), id serial PRIMARY KEY);
CREATE TABLE brand(brand_name VARCHAR(255), id serial PRIMARY KEY);
CREATE TABLE stores_brands(store_id int, brand_id int, id serial PRIMARY KEY);
