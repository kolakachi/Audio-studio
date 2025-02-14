<?php
  define('DB_SERVER', '127.0.0.1');
  define('DB_USERNAME', 'homestead');
  define('DB_PASSWORD', 'homesteadpassword');
  define('DB_DATABASE', 'cloudpolly');
  define('DB_TABLE', 'sounds_saves');

   /* Attempt to connect to MySQL database */
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  // Check connection
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  $query = "SELECT ID FROM ".DB_TABLE;
  $result = mysqli_query($link, $query);

  if(empty($result)) {
    $query = "CREATE TABLE `".DB_TABLE."` (
              `id` int(11) AUTO_INCREMENT,
              `save_name` varchar(300) NOT NULL,
              `save_tracks` text NOT NULL,
              `lastedited` DATETIME NOT NULL,
              PRIMARY KEY  (`id`),
              UNIQUE KEY `save_name` (`save_name`)
              )";
    $result = mysqli_query($link, $query);
  }
?>
