<?php
 require 'Toro.php';


class HelloHandler {
    function get() {
        echo "Hello, world";
    }
}

class FacebookHandler {
    function get() {
        
    }
}

Toro::serve(array(
    "/" => "HelloHandler",
    "/facebook" => "FacebookHandler" 
));
