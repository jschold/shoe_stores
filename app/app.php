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

    $app->get("/stores", function(), use ($app) {
        return app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/brands", function(), use ($app) {
        return app['twig']->render('brands.html.twig', array('brands' => Brands::getAll()));
    });

    $app->post("/stores", function(), use ($app) {
        $store = new Store($_POST['store_name']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/brands", function(), use ($app) {
        $store = new Brand($_POST['brand_name']);
        $store->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });




    return $app;
?>
