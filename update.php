<?php
session_start();
require ('Illusion.php');
$db = new Database;
$id = ( isset( $_REQUEST['id'] ) ) ? $_REQUEST['id'] : '';
if ( isset( $_POST['save'] ) ) {

	$data = array(
	'name'=> $_POST['name'],
	'email'=> $_POST['email'],
	'company'=> $_POST['company'],
	'address'=> $_POST['address'],
	'country' => $_POST['country']
	);
$me = $db->update(null,"id=$id",$data);

if ($me != false ){
	$_SESSION['message'] = 'Record Updated';
	header("location: ./");
}
else {
	$_SESSION['message'] = 'Error Updating Record!';
	header("location: ./");
}

}
else {
	$data = $db->getOne(null,"id=$id");
	?>
	<!DOCTYPE html>
	<html lang="en">
	  <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <title>Theme Template for Bootstrap</title>

	    <!-- Bootstrap core CSS -->
	    <link href="bootstrap.min.css" rel="stylesheet">
	  </head>

		<body>
		<br/>
		<div class="container">
		<div class="col-md-12"><a href="./">Home</a></div>
		<form class="bs-example bs-example-form" data-example-id="simple-input-groups" method="post">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Name</span>
				<input type="hidden" name="id" value="<?=$data['id']?>">
				<input required class="form-control" placeholder="name" name="name" value="<?=$data['name']?>" aria-describedby="basic-addon1">
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Email</span>
				<input required class="form-control" placeholder="email" name="email" value="<?=$data['email']?>" aria-describedby="basic-addon1">
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Company</span>
				<input required class="form-control" placeholder="company" name="company" value="<?=$data['company']?>" aria-describedby="basic-addon1">
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Address</span>
				<input required class="form-control" placeholder="address" name="address"  value="<?=$data['address']?>" aria-describedby="basic-addon1">
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Country</span>
				<input required class="form-control" placeholder="country" name="country" value="<?=$data['country']?>" aria-describedby="basic-addon1">
			</div>
			<div class="input-group">
				<input required class="form-control" name="save" type="submit" aria-describedby="basic-addon1">
			</div>
		</form>

		</div>
		</body>
	</html>
	<?php
}



