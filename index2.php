<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" href="/css/bootstrap.min.css"> -->
</head>
<body>

	<p><br/><br/></p>
	<div class="container"> 
		<?php
		include "config.php";
		if(isset($_FILES ['file'])){
			$name = $_FILES ['file']['name'];
			$size = $_FILES ['file']['size'];
			$type = $_FILES ['file']['type'];
			$tmp = $_FILES ['file']['tmp_name'];
			$file = 'uploads/'.$_FILES ['file']['name'];
			if(!file_exists($file)){

			$super = move_uploaded_file($tmp, $file);
			if ($super) {
				$add = $db->prepare("insert into upload values('',?)");
				$add ->bindParam(1,$name);
				if($add ->execute()){
					?>
					<div class="alert alert-success alert-dismissile" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>SUCCESS!</strong> File has Uploaded and saved to Database.
						
					</div>
				<?php

				}else{
					?>
					<div class="alert alert-danger alert-dismissile" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Failed!</strong> File failed to save in database.
						
					</div>
				<?php
				}
			} else{
				?>
					<div class="alert alert-waring alert-dismissile" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Sorry!</strong> File Yet not Uploaded to Directory.
						
					</div>
				<?php
			}
				}
		}
		?>
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="file"> Upload File</label>
				<input type="file" id="file" name="file">
				<p class="help-block"> All Files</p>
			</div>
			<button type="submit" class="btn btn-default">Upload</button>
		</form>

		<p><br/></p>
		<div class="row">
			<?php
			if(isset($_GET['delete'])){
				$img = $_GET['delete'];
				$id = $_GET['id'];
				$delete = unlink('uploads/'.$img);
				if($delete){
					$del = $db->prepare("delete from upload where id='$id'");
					if($del->execute()){
					?>
					<div class="alert alert-waring alert-dismissile" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> File has Deleted from Directory and Database.	
					</div>
					<?php
					}else{
					?>
					<div class="alert alert-waring alert-dismissile" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Failed</strong> File Failed to delete from Database.	
					</div>
				<?php
			}
				}else{
				?>
					<div class="alert alert-waring alert-dismissile" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!!</strong> File Yet not Deleted from Directory.
						
					</div>
				<?php

			}
			}

			$stmt = $db->prepare("select * from upload");
			$stmt->execute();
			while($row = $stmt->fetch()){
			?>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnil">
					<img style="height: 300px;" src="uploads/<?php echo $row['pic'] ?>" alt="<?php echo $row['pic'] ?>" title="<?php echo $row['pic'] ?>">
					<div class="caption text-center"> 
						<p><a href="?delete=<?php echo $row ['pic'] ?>&id=<?php echo $row['id'] ?>" class="btn btn-danger" role="button">Delete </a></p>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>

	</div>
	<form action="index.php" method="post" enctype="multipart/form-data">
        Click to go back
      <!--   <input type="file" name="image"/> -->
        <input type="submit" name="submit" value="HOMEPAGE"/>
    </form>



<script src="https://ajax.googlrapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/jquery-2.1.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>