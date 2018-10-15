<?php
mysql_connect("localhost","root");
mysql_select_db("test");
	
if(isset($_POST['emp_name'])){
	
	$content=file_get_contents($_FILES['pic']['tmp_name']);
	$content=mysql_escape_string($content);
	
	@list(, , $imtype, ) = getimagesize($_FILES['pic']['tmp_name']);

	if ($imtype == 3){
		$ext="png"; 
	}elseif ($imtype == 2){
		$ext="jpeg";
	}elseif ($imtype == 1){
		$ext="gif";
	}
	
	$q="insert into employees set empname='".$_POST['emp_name']."',profile_pic='".$content."',ext='".$ext."'";
	mysql_query($q);
	header("location: example.php");
}
?>
<html>
	<head>
		<title>PHP Drops :: Storing image in database</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<h2>Save image in Database</h2>
		<form method="post" action="" enctype="multipart/form-data">
			Enter Name:<br/><input type="text" name="emp_name" /><br/><br/>
			Profile Pic:
			<input type="file" name="pic" /><br/><br/>
			<input type="submit" value="Save Image" />
		</form>
	<h2>Saved Images</h2><hr/>	
	<table>
	<?php
		$q="select * from employees";
		$resultset=mysql_query($q);
		if(mysql_num_rows($resultset)==0){
			?>
				<tr>
					<td width="400">No Images Saved</td>
				</tr>
			<?php
		}
		while($rec=mysql_fetch_array($resultset)){
			?>
				<tr>
					<td width="200"><img src="load_image.php?pic_id=<?php echo $rec['id']; ?>"></td>
					<td><?php echo $rec['empname']; ?></td>
				</tr>
			<?php
		}
	
	?>
	</table>
	</body>
</html>

