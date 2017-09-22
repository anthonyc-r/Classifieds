<?php 
	include dirname(__FILE__)."/../../controllers/ListingController.php";
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
    <form method="GET" id="headerSearch" action="Search.php">
 	    <input type="text" name="query" value="<?php print($_GET['query']) ?>" placeholder="Search for listings...">
 	    <input type="submit" value="Search">
    </form>
  </header>
  <?php
  /**ENTER IF !NEWLISTING**/
  if (!newListing()) {
  ?>
  <form action="./New.php" method="POST">
    <span><?php echo $errors ?></span>
    <table>
      <tr>
        <td><label>Title</label></td>
        <td><input type="text" name="title"></td>
      </tr>
      <tr>
        <td><label>Description</label></td>
        <td><textarea name="description"></textarea></td>
      </tr>
      <tr>
        <td><label>Price</label></td>
        <td><input type="text" name="price"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit"></td>
      </tr>
    </table>
  </form>
  <?php
  } 
  else {
  ?>
  <p>Listing submitted!</p>
  <?php
  }
  /**EXIT IF**/ 
  ?>
  <div class="clearfix"></div>
</body>
</html>