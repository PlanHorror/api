<?php
    //Strict typing is a feature in PHP that forces the data type of a variable to be a specific type.
    declare(strict_types=1);
    //Autoload is a function that loads a class when it is called.
    spl_autoload_register(function ($class) {
        require __DIR__ . "/src/" . $class . ".php";
    });
    // Set handler for exceptions must callback a static method
    set_error_handler("Error_handler::handleError");
    set_exception_handler("Error_handler::handleException");
    // Header is a function that sends a raw HTTP header to a client.
    // Content-Type is a header that indicates the media type of the resource.
    header("Content-Type: application/json; charset=UTF-8");
    // var_dump($_SERVER["REQUEST_URI"]);
    // Var_dump will show you the value of the variable
    $v = explode("/", $_SERVER["REQUEST_URI"]);
    // Explode will split the string into an array
    // print_r($v);
    // Print_r will show you the array
    if ($v[1] != "api") {
        http_response_code(404);
        exit();
    }
    $database = new Database("localhost", "root", "", "api");
    $database->connect();
    // -> is used to access the object's properties and methods
    $s = $v[2]??null;
    $controller = new Control(new Gateway($database));
    $controller->request_proccess($_SERVER["REQUEST_METHOD"], $s); 