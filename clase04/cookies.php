<?php
    $valor1 = 'valor_cookie_1';
    $valor2 = 'valor_cookie_2';
    $valor3 = 'valor_cookie_3';

    setcookie("TestCookie1", $valor1);
    setcookie("TestCookie2", $valor2, time()+3600);
    setcookie("TestCookie3", $valor3, time()+3600, "/~cookie/", "test.com", 1);


    var_dump($_COOKIE["TestCookie1"]);
?>