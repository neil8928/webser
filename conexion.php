<?php

class ConexionSQL{

    function ConexionBD(){

        $host='2SIS2-NEIL-VIGI';
        $dbname='bdplanillaisl';
        $username='sa';
        $pasword ='sa';
        $puerto=1433;


        try{
            $conn = new PDO ("sqlsrv:Server=$host,$puerto;Database=$dbname",$username,$pasword);
            echo "Se conectó correctamen a la base de datos";
        }
        catch(PDOException $ex){
            echo ("No se logró conectar correctamente con la base de datos: $dbname, error: $ex");
        }

        return $conn;
    }

}

?>