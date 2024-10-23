<?php 
function getDatabaseConnection(){
    $db = new PDO('sqlite:' . __DIR__ . '/../database/project.db');
    return $db;
}

?>