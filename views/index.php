<?php
  $online = $_REQUEST['ONLINE'];
  $USER = null;
  if($online){
    $USER = $_REQUEST['USER'];
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Детейлинг центры Казахстана</title>
	<?php require_once "head.php"; ?>
</head>
<body class="bg-index">
	<div class="container-fluid p-0">
		<?php require_once "navbar.php"; ?>
		<div class="container-fluid p-0 mt-5">
			<div class="row">
				<div class="col-sm-12">
			   		<div class="title-index">
			   			<h4 class="display-4">DETCAR</h4>
			   		</div>
				</div>
			</div>
		</div>
		<div class="title">
	   		
	   	</div>
	</div>
</body>
<script src="js/jquery-3.5.1.min.js"></script>


<script src="js/bootstrap/bootstrap.min.js"></script>


<script src="js/main.js"></script>
</html>	