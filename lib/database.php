<?php

  class DB{

      public static function connection(){
        // Haetaan tietokantakonfiguraatio
        $connection_config = DatabaseConfig::connection_config();
        $config = $connection_config['config'];

        try {
            // Alustetaan PDO
            if(isset($config['username'])){
              $connection = new PDO($config['resource'], $config['username'], $config['password']);
            }else{
              $connection = new PDO($config['resource']);
            }
            $connection->exec('SET NAMES UTF8');

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
          
        } catch (PDOException $e) {
            die('Virhe tietokantayhteydessä tai tietokantakyselyssä: ' . $e->getMessage());
        }
     
        return $connection;
      }

      public static function test_connection(){
        require 'vendor/ConnectionTest/connection_test.php';

        exit();
      }

  }
