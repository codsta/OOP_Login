<?php
 require 'init.php';
 require 'layouts/header.php';
$user = new Users();
 if(isset($_GET['logOut']) && $_GET['logOut'] == true){
   $user->logOut();
 }
 if(!$user->isLoggedIn()){
   header('Location: index.php');
   die();
 }
?>

      <center>
      <h1 class="center">Dashboard</h1>
      <h2>Hello, <?php echo $_SESSION['USERNAME']; ?></h2>
      <iframe src="https://giphy.com/embed/d2jibZKKA0k3RUgU" width="480" height="270" frameBorder="0"></iframe>
      <a href="dashboard.php?logOut=true" class="logOut">Logout</a>
      </center>

<?php require 'layouts/footer.php'; ?>
