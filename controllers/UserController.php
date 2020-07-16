<?php
  class UserController
  {
    public function postAction($request){
      $data = $request->parameters;
      if(isset($data['username']) && isset($data['walletAddress'])) {
        try {
          $user = new UserModel();
          $user->username = $data['username'];
          $user->walletAddress = $data['walletAddress'];
          $user->add();
          if(isset($user->id)){
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
