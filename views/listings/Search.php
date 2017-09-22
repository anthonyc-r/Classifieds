<?php 
	include dirname(__FILE__).'/../../controllers/ListingController.php';
  include dirname(__FILE__).'/../../controllers/UserController.php';
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
    <h1>Classifieds</h1>
    <?php
    /**ENTER IF LOGIN**/
    if ($user) {
    ?>
    <span>Welcome, <?php echo $user->getName() ?>!</span>
    <?php
    }
    /**ELSE**/
    else {
    ?>
    <form method="POST" id="loginForm" action="">
      <table>
        <tr>
          <td><label>Username: </label></td><td><input type="text" name="username"></td>
          <td rowspan="2"><input type="submit" value="Login"></td>
        </tr><tr>
          <td><label>Password: </label></td><td><input type="password" name="password"></td>
        </tr>
      </table>
    </form>
    <?php
    /**EXIT IF LOGIN**/
    }
    ?>

    <form method="GET" id="headerSearch">
 	    <input type="text" name="query" value="<?php print($_GET['query']) ?>" placeholder="Search for listings...">
 	    <input type="submit" value="Search">
    </form>
  </header>
  <div id="sidebar">
    <p>Set catagory limits</p>
    <p>Set listings per page</p>
    <p>Set price limits</p>
    <p>Set area limits</p>
  </div>
  <div id="listings">
  <?php
  $listings = getListings();
  foreach($listings as $listing) {
    $assoc = $listing->getAssoc();
    $rowid = $listing->getRowid();
    $page = "./View.php?id=$rowid";
    ?>
    <a href="<?php echo $page ?>"><div class="listing">
      <h3><?php echo $assoc['title'] ?></h3>
      <p><?php echo $assoc['description'] ?></p>
      <p><?php echo $assoc['price'] ?></p>
    </div></a>
  <?php } ?>
  <button onclick="redirect('http://test.html')"></button>
  </div>
  <div class="clearfix"></div>
</body>
</html>

