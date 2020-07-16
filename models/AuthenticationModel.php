<?php
  include_once 'library/functions.php';

  class AuthenticationModel{
    public $id;
    public $lookupKey;
    public $cipherText;
    public $iv;

    public function add(){
      if(isset($this->lookupKey) && isset($this->cipherText) && isset($this->iv)) {
        $this->lookupKey = sanitizeString($this->lookupKey);
        $this->cipherText = sanitizeString($this->cipherText);
        $this->iv = sanitizeString($this->iv);
        queryMySQL("INSERT INTO authentication(lookupKey, cipherText, iv) VALUES ('$this->lookupKey', '$this->cipherText', '$this->iv')");
        $this->id = insertID();
      } else {
        throw new Exception('Parameters not set!');
      }
    }

    public function retrieve(){
      if(isset($this->lookupKey)) {
        $result = queryMySQL("SELECT cipherText, iv FROM authentication WHERE lookupKey='$this->lookupKey'");
        if($result->num_rows == 0){
          //Respond with an error
  				throw new Exception('Authentication not found!');
        } else {
          while($row = $result->fetch_assoc()){
            $this->cipherText = $row['cipherText'];
            $this->iv = $row['iv'];
          }
        }
      } else {
        throw new Exception('Lookup key not set!');
      }
    }
  }

?>
