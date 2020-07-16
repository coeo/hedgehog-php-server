<?php
  class AuthenticationController
  {
    public function getAction($request){
      $data = $request->parameters;
      if(isset($data['lookupKey'])) {
        try {
          $auth = new AuthenticationModel();
          $auth->lookupKey = $data['lookupKey'];
          $auth->retrieve();
          if(isset($auth->cipherText) && isset($auth->iv)){
            $response = array(
              'cipherText' => $auth->cipherText,
              'iv' => $auth->iv,
              'lookupKey' => $auth->lookupKey
            );
          } else {
            throw new Exception('Lookup failed!');
          }
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }
      } else {
        $response['status'] = 'ERROR';
        $response['message'] = 'Lookup key not set!';
      }
      return $response;
    }

    public function postAction($request){
      $data = $request->parameters;
      if(isset($data['lookupKey']) && isset($data['cipherText']) && isset($data['iv'])) {
        try {
          $auth = new AuthenticationModel();
          $auth->lookupKey = $data['lookupKey'];
          $auth->cipherText = $data['cipherText'];
          $auth->iv = $data['iv'];
          $auth->add();
          if(isset($auth->id)){
            $response['status'] = 'OK';
          } else {
            throw new Exception('Failed to post data!');
          }
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }
      } else {
        $response['status'] = 'ERROR';
        $response['message'] = 'Parameters not set!';
      }
      return $response;
    }
  }
?>
