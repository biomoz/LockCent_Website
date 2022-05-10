<?php
class API{
    
    private $db = '';

    function __construct(){
        $this->dbConnection();
    }

    function dbConnection(){
        $db_user = "BuVg5vx3v6";
        $db_pass = "nlbkpvJADI";
        $db_name = "BuVg5vx3v6";

        $this->db = new PDO('mysql:host=remotemysql.com;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function outputData($username){
        $sql = "SELECT username, ekey FROM user_accounts WHERE username='$username'";
        $result = $this->db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $enc_ekey= (binary)$row["ekey"];
        
        $sql = "SELECT username, notes FROM user_data WHERE username='$username'";
        $result = $this->db->query($sql);
        
        if ($result->rowCount() > 0) {
          // output data of each row
          $row = $result->fetch(PDO::FETCH_ASSOC);
          $notes = $row["notes"];
          $method = 'aes-256-cbc';
          $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
          $dec_notes = openssl_decrypt(base64_decode($notes), $method, $enc_ekey, OPENSSL_RAW_DATA, $iv);
          return $dec_notes;
        }

    }

}

?>