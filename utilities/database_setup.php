<?php

// connecting to the database

$dbuser = 'root';//'explharw' or 'root'
$dbpass = '';//'qEfS7C7lwc5t' or ''

$eepdo = new PDO('mysql:dbhost=localhost;dbname=ExplorerEarthDataBase', $dbuser, $dbpass);
$eepdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$eepdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

