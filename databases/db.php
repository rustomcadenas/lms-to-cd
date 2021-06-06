<?php 

class DB{
    private static function connect(){ 
        // Note that the database need to be put directly. 
        // in creating the database. delete first the dbname.
        //server name, database name, user name, password.
        $conn = new PDO("mysql:host=localhost;dbname=lms_final", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    public static function query($query){  
        $conn = self::connect(); 
       if($conn->exec($query)){
           return true;
       }else{
           return false;
       }
    }

}