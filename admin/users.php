<?php 
	require_once '../core/init.php';
	if(!is_logged_in()){
		login_error_redirect();
	}
	if(!has_permission('admin')){
		permission_error_redirect('index.php');
	}
	include 'includes/head.php';
	include 'includes/navigation.php';
	

	
	if(isset($_GET['delete'])){
		$delete_id = sanitize($_GET['delete']);
		$db->query("DELETE FROM users WHERE id = '$delete_id'");
		$_SESSION['success_flash'] = 'User has been deleted.';
		header('Location: users.php');
	}
	
	if(isset($_GET['add']) || isset($_GET['edit'])){
		$name = ((isset($_POST['name']))? sanitize($_POST['name']) : '');
		$email = ((isset($_POST['email']))? sanitize($_POST['email']) : '');
		$password = ((isset($_POST['password']))? sanitize($_POST['password']) : '');
		$confirm = ((isset($_POST['confirm']))? sanitize($_POST['confirm']) : '');
		$permissions = ((isset($_POST['permissions']))? sanitize($_POST['permissions']) : '');
		$errors = array();
		
		if(isset($_GET['edit'])){
			$useredit_id = (int)$_GET['edit'];
			$useredit_id = sanitize($useredit_id
			);
			$userResults = $db->query("SELECT * FROM users WHERE id = '$useredit_id'");
			$user = mysqli_fetch_assoc($userResults);
			
			
		}			
			
		if($_POST){
		$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
		$emailCount = mysqli_num_rows($emailQuery);
		
		if($emailCount !=0){
			$errors[] = 'That email already exists in our database';
		}
			
		$required = array('name', 'email', 'password', 'permissions');
		foreach($required as $f){
			
			if(empty($_POST[$f])){
				$errors[]='You must fill out all fields';
				break;
			}
			}
			if(strlen($password)< 6){
				$errors[]='Your password must be at least 6 characters';
			}
			if($password != $confirm){
				$errors[] = 'Your passwords do not match';
				}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid email';
			}
			if(!empty($errors)){
				echo display_errors($errors);
				}else{
					//add user to db
					$hashed = password_hash($password, PASSWORD_DEFAULT);
					$insertSql = "INSERT INTO users(`full_name`, `email`, `password`, `permissions`) 
					                        VALUES ('$name', '$email', '$hashed', '$permissions')";
					if(isset($_GET['edit'])){
					$insertSql = "UPDATE users SET full_name='$name', email='$email', password='$password',
					'permissions' = '$permissions' WHERE id = '$useredit_id'"; 
					}
					$db->query($insertSql);
					$_SESSION['success_flash'] = 'User has been added!';
					header('Location: users.php');
					
											
			}
		}
		
		
	?>
		<br>
		<h2 class="text-center"><?=((isset($_GET['edit']))? 'Edit ' : 'Add a new ');?>user</h2><hr>
		<form action="users.php?<?= ((isset($_GET['edit']))? 'edit='.$useredit_id : 'add=1');?>" method="POST">
			<div class="form-group col-md-6">
				<label for="name">Full name:</label>
				<input type="text" id ="name" name="name" class="form-control" value="<?=((isset($_GET['edit']))? $user['full_name'] : $name);?>">
			</div>
			
			<div class="form-group col-md-6">
				<label for="email">Email:</label>
				<input type="email" id ="email" name="email" class="form-control" value="<?=((isset($_GET['edit']))? $user['email'] : $email);?>">
			</div>
			
			<div class="form-group col-md-6">
				<label for="password">Password:</label>
				<input type="password" id ="password" name="password" class="form-control" value="<?=((isset($_GET['edit']))? $user['password'] : $password); ?>">
			</div>
			
			<div class="form-group col-md-6">
				<label for="confirm">Confirm password:</label>
				<input type="password" id ="confirm" name="confirm" class="form-control" value="<?=((isset($_GET['edit']))? $user['password'] : $password); ?>">
			</div>
			
			<div class="form-group col-md-6">
				<label for="name">Permissions:</label>
				<select class="form-control" name="permissions">
					<option value=""<?=(($permissions == '')? 'selected' : '');?>></option>
					<option value="editor"<?=(($permissions == '')? 'selected' : '');?>>Editor</option>
					<option value=""<?=(($permissions == 'admin,editor')? 'selected' : '');?>>Admin</option>
				</select>
			</div>
			<div class="form-group col-md-6 text-right" style="margin-top:25px;">
			<a href="users.php" class="btn btn-default">Cancel</a>
			<input type="submit" value="<?=((isset($_GET['edit']))? 'Edit ' : 'Add ');?> user" class="btn btn-primary">
			</div>
		</form>
	<?php
		
	}else{
	
	$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");
?>

<br><h2 class="text-center">Users</h2><br>
<a href="users.php?<?= ((isset($_GET['edit']))? 'edit='.$useredit_id : 'add=1');?>" class="btn btn-success pull-right" id="add-product-btn">Add new user</a>
<hr>
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<th></th>
		<th>Name</th>
		<th>Email</th>
		<th>Join date</th>
		<th>Last login</th>
		<th>Permisions</th>
	</thead>		
		<tbody>
		<?php
			while($user = mysqli_fetch_assoc($userQuery)):
		?>
			<tr>
				<td>
					<?php 
						if($user['id'] != $user_data['id']):
					?>	
						<a href="users.php?edit=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
						
						<a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
					
					<?php
						endif;
					?>
					
				</td>
				<td><?= $user['full_name']; ?></td>
				<td><?= $user['email']; ?></td>
				<td><?=pretty_date($user['join_date']);?></td>
				<td><?=(($user['last_login'] == '0000-00-00 00:00:00')?'Never' : pretty_date($user['last_login']));?></td>
				<td><?= $user['permissions']; ?></td>
			</tr>
		<?php
			endwhile;
		?>
		</tbody>
	</table>

<?php 
	}
include 'includes/footer.php';
?>