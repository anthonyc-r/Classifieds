<?php
$page = <<<HTML
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
    <form method="GET" id="headerSearch">
 	    <input type="text" placeholder="Search for listings...">
 	    <input type="submit" value="Search">
    </form>
  </header>
  <div id="content">
    $content
  </div>
  <div class="clearfix"></div>
</body>
</html>
HTML;
?>

<?php echo $page ?>