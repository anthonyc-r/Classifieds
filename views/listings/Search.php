<?php 
include dirname(__FILE__).'/../../controllers/ListingController.php';
include dirname(__FILE__).'/../templates/PageTemplateStart.php';
$currentFilter = getAppliedFilter();
?>

<div id="sidebar">
	<h2>Filter Results</h2>
	<form id="filterForm" action="" method="GET">
		<table>
			<tr>
				<td colspan="2"><h3>Price</h3></td>
			</tr>
			<tr>
				<td><p>Min:</p></td>
				<td><input type="text" name="minPrice" placeholder="£0" value="<?php echo $currentFilter->getMinPrice() ?>"/></td>
			</tr>
			<tr>
				<td><p>Max:</p></td>
				<td><input type="text" name="maxPrice" placeholder="£0" value="<?php echo $currentFilter->getMaxPrice() ?>"/></td>
			</tr>
		</table>
		<td colspan="2"><input id="submitButton" type="submit" value="Apply" /></td>
	</form>
</div>


<div id="listings">
<?php
$listings = getListings();
foreach($listings as $listing) {
  $rowid = $listing->getRowid();
  $page = "./View.php?id=$rowid";
  ?>
  <div class='listing'><a href='<?php echo $page ?>'>
    <h3><?php echo $listing->title ?></h3>
    <p><?php echo $listing->description ?></p>
    <p><?php echo $listing->getFormattedPrice() ?></p>
  </a></div>
<?php } ?>

<nav class="pageSelection">
  <?php
  $layout = getPagingLayout();
  if ($layout['showFirstPageLink']) {
  ?>
  
    <a href="<?php echo getUrlForPage(1) ?>">1</a>... 
  
  <?php
  }
  for ($i = $layout['lowerBound']; $i <= $layout['upperBound']; $i++) {
    if ($i == getCurrentPage()) {
	  echo $i;
	}
	else {
  ?>

  	<a href="<?php echo getUrlForPage($i) ?>"><?php echo $i ?></a>

  <?php
  	}
  }
  if ($layout['showLastPageLink']) {
  ?>

    ... <a href="<?php echo getUrlForPage($layout['maxPages']) ?>"><?php echo $layout['maxPages'] ?></a>

  <?php
  }
  ?>
</nav>
</div>

<?php
include dirname(__FILE__).'/../templates/PageTemplateEnd.php';
?>
