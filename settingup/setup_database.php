<?php

try {
    $newDB = new PDO("mysql:host=localhost", 'explharw', 'qEfS7C7lwc5t');
    
    $newDB->exec("CREATE DATABASE explharw_ExplorerEarthDataBase; "
            . "GRANT ALL ON ExplorerEarthDataBase.* to 'explharw_accessEEDB'@'localhost' IDENTIFIED BY 'kwbIvIEYDFKjkvb1236@#$%!sdfaDA';")
            or die(print_r($newDB->errorInfo(), true));
} catch (PDOException $ex) {
    die("DB Error: ". $ex->getMessage());
}

?>