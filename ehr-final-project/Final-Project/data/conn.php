<?php
    if(!class_exists('conn')){

        class conn{
            public static function getConnection(){
                try{
                    $dsn = "mysql:dbname=ehr_db";
                    $username = "ehr_user";
                    $password = "1234";

                    $conn = new PDO($dsn, $username, $password);
                    $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $conn;
                }
                catch (Exception $e){
                    throw $e;
                }
            }
        }
    }
?>