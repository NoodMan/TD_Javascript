<?php
define( // creation de la constante
    'IS_AJAX',
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) =='xmlhttprequest'
);
// == pour faire une comparaison

if (!'IS_AJAX') { // si faux 
    die('Restriced access');
}