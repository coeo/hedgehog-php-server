<?php
  include_once 'library/functions.php';

  class UserModel{
    public $id;
    public $username;
    public $walletAddress;

    public function add(){
      if(isset($this->username) && isset($this->walletAddress)) {
        $this->username = sanitizeString($this->username);
        $this->walletAddress = sanitizeString($this->walletAddress);
        queryMySQL("INSERT INTO user(username, walletAddress) VALUES ('$this->username', '$this->walletAddress')");
        $this->id = insertID();
      } else {
        throw new Exception('Parameters not set!');
      }
    }
  }

?>
