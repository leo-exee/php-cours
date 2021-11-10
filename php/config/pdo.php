<?php 
    require_once 'config.php';

      try {
        $conn = new PDO($param, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if ($conn) {
          echo 'Connected';
        }
      } catch (PDOException $ex) {
        return $conn;
      }