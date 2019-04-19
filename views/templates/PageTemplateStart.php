<?php 
  include dirname(__FILE__).'/../../controllers/Controller.php';
  $user = login(); //Cookies set.
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Listings...</title>
  <link type="text/css" rel="stylesheet" href="../css/style.css">
  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/script.js"></script>
</head>
<body>
  <header>
    <a href="../listings/Search.php"class="title">Classifieds</a>
	<div id="userInfo" class="widget">
    <?php
    /**ENTER IF LOGIN**/
    if ($user) {
    ?>
      <p1>Welcome, <?php echo $user->getName() ?>!</p1>
	  <a href="../user/Logout.php">Logout</a>
    <?php
    }
    /**ELSE**/
    else {
    ?>
      <form method="POST" id="loginForm" action="">
        <table>
          <tr>
            <td><label>Username: </label></td><td><input type="text" name="username"></td>
            <td><input type="submit" value="Login"></td>
          </tr><tr>
            <td><label>Password: </label></td><td><input type="password" name="password"></td>
  		    <td><a href="../user/Register.php">Register</a></td>
          </tr>
        </table>
      </form>
    <?php
    /**EXIT IF LOGIN**/
    }
    ?>
	</div>

    <form method="GET" id="headerSearch" class="widget" action="../listings/Search.php">
 	    <input type="text" name="query" placeholder="Search for listings...">
 	    <input type="submit" value="Search">
    </form>
  </header>
  <div id="content">

