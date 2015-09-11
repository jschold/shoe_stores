<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoe_stores';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //Homepage
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores'=>Store::getAll(), 'brands' =>Brand::getAll()));
    });

    //Storepage
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    //Brandspage
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    //Storepage displays brands carried
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //Brandspage displays stores that carry them
    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    //Finds store that will be edited
    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store));
    });

    //Posts new store to storepage
    $app->post("/stores", function() use ($app) {
        $store = new Store($_POST['store_name']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //Posts new brand to brandpage
    $app->post("/brands", function() use ($app) {
        $store = new Brand($_POST['brand_name']);
        $store->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Assigns brands carried to storepage
    $app->post("/add_brands", function() use ($app) {
       $store = Store::find($_POST['store_id']);
       $brand = Brand::find($_POST['brand_id']);
       $store->addBrand($brand);
       return $app['twig']->render('store.html.twig', array('store' => $store,
       'stores' => Store::getAll(),
       'brands' => $store->getBrands(),
       'all_brands' => Brand::getAll()));
    });

    //Assigns stores to brandpage
    $app->post("/add_stores", function() use($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand,
        'brands' => Brand::getAll(),
        'stores' => $brand->getStores(),
        'all_stores' => Store::getAll()));
    });

    //Deletes all stores
    $app->post("/delete_stores_confirm", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('delete_stores_confirm.html.twig');
    });

    //Updates new store information
    $app->patch("stores/{id}", function($id) use ($app) {
        $store_name = $_POST['store_name'];
        $store = Store::find($id);
        $store->update($store_name);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //Deletes one store
   $app->delete("/stores/{id}", function($id) use ($app) {
       $store = Store::find($id);
       $store->deleteOne();
       return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
   });

   //Deletes all brands
   $app->post("/delete_brands_confirm", function() use ($app) {
       Brand::deleteAll();
       return $app['twig']->render('delete_brands_confirm.html.twig');
   });

    return $app;
?>
