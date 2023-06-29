<?php
class connection{
    function conn(){
        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "text_preprocess";

        $con = mysqli_connect($server,$username,$password,$database);
        if(!$con){
            die("connetion failed:".mysqli_connect_error());
        }
        return $con;
    }
}