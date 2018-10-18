<?php

class Users
{
  public function signUp($username, $password)
  {
    $db = new Database();
    $data = array('Username'=> $username, 'Password'=>$password);
    if(!$this->isUserUnique($username)){
      $errors[] = 'Username Already Exists. Please Try Another';
      return array('result'=> false , 'output'=> $errors);
    }
    $valid = $this->validate($data);

    if(!$valid['result']){
      return $valid;
    }
    return $db->signUp($valid['output']['Username'],$valid['output']['Password']) ? true : false;
  }
  public function isUserUnique($username)
  {
    $db= new Database();

    if(!$db->isUserUnique($username))
    {
      return false;
    }
    return true;
  }
  public function signIn($username,$password)
  {
    $db = new Database();
    $user = $db->signIn($username,$password);
    if(!$user)
    {
      return false;
    }
    $_SESSION['USERID'] = $user['user_id'];
    $_SESSION['USERNAME'] = $user['username'];
    header('Location: dashboard.php');

  }
  public function isLoggedIn()
  {
    if(!isset($_SESSION['USERID']))
    {
      return false;
    }
    return true;
  }
  public function logOut()
  {
    unset($_SESSION['USERID']);
    unset($_SESSION['USERNAME']);
    session_destroy();
    header('Location: index.php');
  }
  public function validate($arrdata)
  {
    $errors=[];
    foreach ($arrdata as $key=>$data) {
      if (empty($data))
      {
        $errors[] = "{$key} cannot be empty";
      }
      if (strlen($data) < 4 && strlen($data) > 12 )
      {
        $errors[] = "{$key} should be between 4 to 12 characters";
      }
      if(preg_match('/[\'^%&*()}\[\]{#~?><>,|=_+¬-]/', $data))
      {
        $errors[] = "Allowed characters for {$key} : Alphabets,Numbers & Special Characters: $,@";
      }
    }

    if(empty($errors)){
      $data = $this->trimStrip($arrdata);
      return array('result'=> true , 'output'=>$data);
    }
    else{
      return array('result'=> false , 'output'=>$errors);
    }
  }
  public function trimStrip($arrdata)
  {
    $new_data=[];
    foreach ($arrdata as $key => $data) {
      $new_data[$key] = strip_tags(trim($data));
    }
    return $new_data;
  }


}
