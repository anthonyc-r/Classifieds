<?php 
	include dirname(__FILE__)."/../../controllers/ListingController.php";
  include dirname(__FILE__).'/../../controllers/UserController.php';

  $user = login();
  $listing = getListing();
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
    <form method="GET" id="headerSearch" action="Search.php">
 	    <input type="text" name="query" value="<?php print($_GET['query']) ?>" placeholder="Search for listings...">
 	    <input type="submit" value="Search">
    </form>
  </header>
  <article>
    <?php
    /**ENTER IF LISTING**/
    if ($listing) {
      $listing = $listing->getAssoc();
      
echo <<<HTML
<table id="listing">
  <tr>
    <td><h2>title</h2></td>
    <td>{$listing['title']}</td>
  </tr>
  <tr>
    <td><h2>Description: </h2></td>
    <td><p>{$listing['description']}</p></td>
  </tr>
  <tr>
    <td><h2>Price: </h2></td>
    <td>{$listing['price']}</td>
  </tr>
</table>
HTML;

    }
    else {
    ?>
    <h1>Ooops, something went wrong :(</h1>
    <?php
    /**EXIT IF LISTING**/
    }
    ?>
  </article>
  <div class="clearfix"></div>
</body>
</html>