<?php
 require 'Toro.php';
 require 'lib/facebook.php';

class HelloHandler {
    function get() {
        echo "Hello, world";
    }
}

class FacebookHandler {
    function get() {
        Facebook();
    }
}

Toro::serve(array(
    "/" => "HelloHandler",
    "/facebook" => "FacebookHandler" 
));
