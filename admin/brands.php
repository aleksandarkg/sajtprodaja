<?php 
	require_once '../core/init.php';
		if(!is_logged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';
	include 'includes/navigation.php';
	
	//get brands from db
	
	$sql = "SELECT * FROM brand ORDER BY brand";
	$result = $db->query($sql);
	$errors = array();
	// If add form is submitted
	
	if(isset($_POST['add_submit'])) {
		$brand = sanitize($_POST['brand']);
			// check if brand is blank
			
			if($_POST['brand'] == '') {
				$errors[].='You must enter a brand!';
			}
			// check if brand exists in db
			$sql = "SELECT * FROM brand WHERE brand = '$brand'";
			$result = $db->query($sql);
			$count = mysqli_num_rows($result);
			if($count > 0){
				$errors[] .= $brand.' already exists. Please choose another brand name.';
			}
			
			//display errors
			
			if(!empty($errors)){
				echo display_errors($errors);
			} else {
				//Add brand to db
				$sql = "INSERT INTO brand (brand) VALUES ('$brand')";
				$db->query($sql);
				header('Location: brands.php');
			}
	}
?>
<br>
<h2 class="text-center">Brands</h2><hr>
<!-- Brand form -->

<div class="text-center">
	<form class="form-inline" action="brands.php" method="POST">
		<div class="form-group">
			<label for="brand">Add a brand</label>
			<input type="text" name="brand" id="brand" class="form-control" value="<?=((isset($_POST['brand']))?$_POST['brand']:'');?>">
			<input type="submit" name="add_submit" value="Add brand" class="btn btn-success">
		</div>
	
	</form>
</div>
<hr>

<table class="table table-bordered table-striped table-condensed" style="width:auto; margin:0 auto;" />
	<thead>
		<th></th>
		<th class="text-center">Brand</th>
		<th></th>
	</thead>
		<tbody>
			<?php while($brand = mysqli_fetch_assoc($result)): ?>
				<tr>
					<td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
					<td><?= $brand['brand'];?></td>
					<td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
</table>

<?php 
include 'includes/footer.php';
?>