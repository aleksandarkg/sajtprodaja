<?php
	$cat_id = ((isset($_REQUEST['cat']))? sanitize($_REQUEST['cat']) : '' );
	$price_sort = ((isset($_REQUEST['price_sort']))? sanitize($_REQUEST['price_sort']) : '');
	$min_price = ((isset($_REQUEST['min_price']))? sanitize($_REQUEST['min_price']) : '' );
	$max_price = ((isset($_REQUEST['max_price']))? sanitize($_REQUEST['max_price']) : '' );
	$b = ((isset($_REQUEST['brand']))? sanitize($_REQUEST['brand']) : '' );
	$brandQ = $db->query("SELECT * FROM brand ORDER BY brand");
?>
<br>
<h3 class="text-center">Search by:</h3><br>
<h4 class="text-center">Price</h4><br>
<form action="search.php" method="POST">
	<input type="hidden" name="cat" value="<?= $cat_id; ?>">
	<input type="hidden" name="price_sort" value="0">
	<input type="radio" name="price_sort" value="low"<?=(($price_sort == 'low')? 'checked' : '' ); ?>>Low to high<br>
	<input type="radio" name="price_sort" value="high"<?= (($price_sort == 'high')? 'checked' : '' ); ?>>High to low<br><br>
	<input type="text" name="min_price" class="price-range" placeholder="Min $" value="<?= $min_price; ?>">To
	<input type="text" name="max_price" class="price-range" placeholder="Max $" value="<?= $max_price; ?>"><br><br>
	<h4 class="text-center">Brand</h4><br>
	<input type="radio" name="brand" value=""<?=(($b=='')? 'checked' : '');?>>&nbspAll<br>
	<?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
	<input type="radio" name="brand" value="<?= $brand['id']; ?>"<?= (($b== $brand['id'])? 'checked' : '');?>>&nbsp<?=$brand['brand'];?><br>
	<?php endwhile; ?>
	<br>
	<input type="submit" value="Search" class="btn btn-xs btn-primary">	
</form>