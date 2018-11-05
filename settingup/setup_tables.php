<?php



try{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/explorerearthsourcecode/utilities/database_setup.php';
    $eepdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $queryT1 = "CREATE TABLE IF NOT EXISTS User ("
            . " user_ID INT UNSIGNED NOT NULL AUTO_INCREMENT KEY,"
            . " user_type ENUM('public', 'admin'),"
            . " email VARCHAR(128) NOT NULL UNIQUE,"
            . " displayed_name VARCHAR(128) NOT NULL UNIQUE,"
            . " full_name VARCHAR(128) NOT NULL,"
            . " password VARCHAR(128) NOT NULL,"
            . " date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $queryT2 = "CREATE TABLE IF NOT EXISTS Posts ("
            . "post_ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
            . "creator_ID INT UNSIGNED NOT NULL,"
            . "title VARCHAR(1024),"
            . "content longtext,"
            . "latest_updat_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
            . "dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    
    $queryT3 = "CREATE TABLE IF NOT EXISTS Images ("
            . "image_ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
            . "creator_ID INT UNSIGNED NOT NULL,"
            . "post_ID int UNSIGNED,"
            . "image_name VARCHAR(128),"
            . "image LONGBLOB NOT NULL,"
            . "date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,"
            . "imageDescription text)";

        //     user profile image
    $queryT4 = "CREATE TABLE IF NOT EXISTS ProfileImages ("
            . "id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
            . "creator_ID INT UNSIGNED NOT NULL,"
            . "image LONGBLOB NOT NULL,"
            . "date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,"
            . "imageDescription text)";


    $queryT5 = "CREATE TABLE IF NOT EXISTS comments ("
                . "comment_ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
                . "post_ID INT UNSIGNED NOT NULL,"
                . "user_ID INT UNSIGNED NOT NULL,"
                . "comment text,"
                . "date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $eepdo->exec($queryT1);
    print("Created user table");
    $eepdo->exec($queryT2);
    print("<br>Created Posts table");
    $eepdo->exec($queryT3);
    print("<br>Created images table");
    $eepdo->exec($queryT4);
    print("<br>Created profileImages table");
    $eepdo->exec($queryT5);
    print("<br>created comments table");
} catch (PDOException $e) {
    echo $e->getMessage();
}    


//INSERT INTO user(user_type, email,displayed_name,full_name,password) VALUES (1,'rafik.mohammad1994@gmail.com','Hamalaw','Mohammad Rafik',280994);
// OMG IT FINALLY WORKED HOORAY!