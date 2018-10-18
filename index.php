<?php
 require 'init.php';
 if(isset($_SESSION['USERID']))
 {
   header('Location: dashboard.php');
   exit();
 }
 require 'layouts/header.php';
 ?>

<?php
 $result = NULL;
  if($_SERVER['REQUEST_METHOD'] === 'POST' )
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new Users();
    if(isset($_POST["signin"]) ){
      $result = $user->signIn($username,$password);
    }
    if(isset($_POST["signup"])){
      $result = $user->signUp($username,$password);
    }
  }
?>

      <h1 class="center">Sign In / Sign Up Tutorial</h1>
      <div class="img-login">
        <img src="login.png" alt="" width="200" height="auto">
      </div>
      <div class="alerts">
        <?php if($result === true ) : ?>
          <div class="notice success">
            <p>Successfully created a new user</p>
          </div>
        <?php
        endif; ?>
        <?php if( isset($result['result']) &&  $result['result'] === false ) : ?>
          <div class="notice error">
            <p>
            <?php

              foreach ($result['output'] as $notice) {
                echo "{$notice} <br>";
              }
             ?>
           </p>
          </div>
        <?php endif; ?>
        <?php if( $result === false  ) : ?>
          <div class="notice error">
            <p>
            <?php
                echo "Username and password do not match. Please try again.";
             ?>
           </p>
          </div>
        <?php endif; ?>

      </div>

      <div class="buttons">
        <button onclick="document.getElementById('id01').style.display='block'" class="signin"><i class="fas fa-sign-in-alt"></i><br>Login</button>
        <button onclick="document.getElementById('id02').style.display='block'" class="signup"><i class="fas fa-user-plus"></i><br>Create New Account</button>
      </div>

      <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="modal-container">
            <h1>Login</h1>
            <p></p>
            <hr>
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter desired username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <div class="clearfix">
              <button type="submit" class="signin" name="signin">Login</button>
              <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
          </div>
        </form>
      </div>

      <div id="id02" class="modal">
        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
        <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="modal-container">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter desired username" name="username" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <div class="clearfix">

              <button type="submit" class="signup" name="signup">Sign Up</button>
              <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
          </div>
        </form>
      </div>

<?php require 'layouts/footer.php'; ?>
