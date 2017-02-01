<?php
session_start();
require ('Illusion.php');
$db = new Database;
$req = ( isset( $_REQUEST['id'] ) ) ? $_REQUEST['id'] : '';
$search = ( isset( $_REQUEST['search'] ) ) ? $_REQUEST['search'] : '';
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
		<div class="container">

<?php
if ($req != '' ) {

	// View dat by ID
	foreach ($db->getOne(null,"id='$req'") as $key => $value) {
		# code...

		print_r( 
			$value		 
		);
		echo "<br/>";

	}
	die;

}
else {

	if ($search != '' ) {
		// filter by search

		?>
		<br/>
		<div class="row">
			<div class="col-md-6"><a href="./">View All </a>   | <a href="add.php"> Add</a> </div>
			<div class="col-md-6"> <form action="?s="><input type="text" name="search" placeholder="<?=$search?>"> <input type="submit" value="Search"/></form></div>
		    
		        <div class="col-md-12">
		          <table class="table">
		            <thead>
		              <tr>
		                <th>#</th>
		                <th>Name</th>
		                <th>Email</th>
		                <th>Company</th>
		                <th>Address</th>
		                <th>Country</th>
		                <th>Act</th>
		              </tr>
		            </thead>
		            <tbody>
		<?php
		$no=0;
		foreach ($db->getAllBy(null,"name LIKE '%$search%'",'','5') as $key => $value) {
			$no++;
			?>
			
		              <tr>
		              	<td><?=$no?></td>
		                <td><?=$value['name']?></td>
		                <td><?=$value['email']?></td>
		                <td><?=$value['company']?></td>
		                <td><?=$value['address']?></td>
		                <td><?=$value['country']?></td>
		                <td>
		                	<a href="update.php?id=<?=$value['id']?>">Edit</a>
		                	<a href="delete.php?id=<?=$value['id']?>">Delete</a>
		                </td>
		              </tr>
		            
			<?php
		}
		?>
					</tbody>
		          </table>
		        </div>
	      	</div>
		<?php
	}
	else
	{
		// Display All Data
		?>
			
			<br/>
			<div class="row">
			<?php
				if(isset($_SESSION['message'])){
				echo "<span>" . $_SESSION['message'] . "</span><br/>";
				}
			?>
				<div class="col-md-6"><a href="add.php">Add</a></div>
				<div class="col-md-6"><form action="?s="><input type="text" name="search" placeholder="<?=$search?>"> <input type="submit" value="Search"/></form></div>
		        <div class="col-md-12">
		          <table class="table">
		            <thead>
		              <tr>
		                <th>#</th>
		                <th>Name</th>
		                <th>Email</th>
		                <th>Company</th>
		                <th>Address</th>
		                <th>Country</th>
		                <th>Act</th>
		              </tr>
		            </thead>
		            <tbody>
		<?php
		$no=0;
		foreach ($db->getAllBy(null) as $key => $value) {
			$no++;
			?>
			
		              <tr>
		              	<td><?=$no?></td>
		                <td><?=$value['name']?></td>
		                <td><?=$value['email']?></td>
		                <td><?=$value['company']?></td>
		                <td><?=$value['address']?></td>
		                <td><?=$value['country']?></td>
		                <td>
		                	<a href="update.php?id=<?=$value['id']?>">Edit</a>
		                	<a href="delete.php?id=<?=$value['id']?>">Delete</a>
		                </td>
		              </tr>
		            
			<?php
		}
		?>
					</tbody>
		          </table>
		        </div>
	      	</div>
		<?php
	}

}
if(isset($_SESSION['message'])){
	unset($_SESSION['message']);
}
?>
		</div>
	</body>
</html>