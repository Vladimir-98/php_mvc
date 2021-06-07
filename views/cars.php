<?php
  $online = $_REQUEST['ONLINE'];
  $USER = null;
  if($online){
    $USER = $_REQUEST['USER'];
  }
  $key=null;
  

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Детейлинг центр</title>
		<?php require_once "head.php"; ?>
	</head>
	<body>
		<div class="container-fluid p-0">
			<?php require_once "navbar.php"; ?>
			<div class="container p-0 mt-5">
				<?php if(isset($_GET['key']) && $_GET['key']!=null){ $key = $_GET['key'];?>
				<div>
					<h3 class="reviews_list_title display-4"><?php echo 'Поиск по запросу "'.$key.'"';?></h3>
				</div>
				<?php }?>
				<?php if($key==null){?>
				<div class="h1_title">
					<h1 class="page_title display-4">Услуги</h1>
				</div>
				<?php } ?>
				<div class="row ml-3">
					<div class="col-sm-12">
						<?php if(isset($_REQUEST['USER']) && $USER->email == "super.admin@mail.kz"){?>
						<button type="button" class="btn_white btn ml-auto" data-toggle="modal" data-target="#addCar" id="buttonAddCar" <?php if(!$online){ echo "style='display: none;'" ;} ?>>добавить услугу</button>
						<?php } ?>
					</div>
				</div>
				<div class="row ml-3">
					<div class="col-sm-12 mt-5">
						<div class="filters_box">
							<a href="javascript:void(0)" class="filters_open">Фильтры</a>
							<input type="hidden" id="dataSortName" value="">
							<i class="fas fa-filter"></i>
						</div>
						<div class="sort_box">
							<div class="sort">
								<a href="javascript:void(0)" class="service_sort" id="sortReviews">отзывы</a>
								<a href="javascript:void(0)" class="service_sort" id="sortName">название</a>
								<a href="javascript:void(0)" class="service_sort" id="sortDate">дата добавления</a>
							</div>
						</div>
					</div>
				</div>
				    
				<!-- Modal auth -->
				<div class="modal fade" id="addCar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-xl">
				    <div class="modal-content">
				        <div class="modal-header">
				          <h5 class="modal-title" id="exampleModalLabel">Новая услуга.</h5>
				          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				            <span aria-hidden="true">&times;</span>
				          </button>
				        </div>
				        <div class="modal-body">							  
							<form enctype="multipart/form-data" id="myForm">
							 	<div class="row">
							 		<div class="col-sm-8 mx-auto">
							 			<div class="row mt-5">
											<div class="col-sm-7 mx-auto">
												<a class="new_img cars_img_left"><img class=" mt_default" src="img/default_1.jpg" alt="">1</a>	
												<a class="new_img cars_img_left"><img class=" mt_default" src="img/default_1.jpg" alt="">2</a>
											</div>
											<div class="col-sm-5">
												<a class="new_img cars_img_right"><img src="img/default_2.jpg" alt="">3</a>
											</div>
										</div>
										<div class="row">
											<div class="fileform mb-2 m-5 mx-auto">
												<input class="avatar" type="file" name="file" id="file" multiple="multiple">
											</div>
										</div>
							 		</div>
							 	</div>
							    <div class="form-group">
							      <label for="email">ЗАГОЛОВОК</label>
							      <input type="text" name="title_service" class="form-control" id="title_service" aria-describedby="emailHelp">
							    </div>
							    <div class="form-group">
							      <label for="exampleInputPassword1">ОПИСАНИЕ</label>
							      <input type="text" name="description_service" class="form-control" id="description_service">
							    </div>
							    <div class="form-group">
							      <label for="exampleInputPassword1">ТЕКСТ</label>
							      <textarea  type="text" name="text_service" class="form-control" id="text_service"></textarea>
							    </div>
						      <div class="reg-btn-box">
						        <a type="button" class="btn" data-dismiss="modal">отмена</a>
						        <button type="button" class="btn_white btn" id="addService" >отправить</button>
						      </div>
							</form>
							<div class="alert alert_danger" id="img_error">							  
							</div>
						</div>
				    </div>
				  </div>
				</div>
			</div>
			<div class="container p-0 mt-5">
				<div class="preload">
					<img src="img/icons/preload.gif">
				</div>
			</div>
			<div class="container p-0" id="get_all_services">
			</div>
			<div class="container">
				<div class="row">
					<div class="pageno">
				    	<div class="pageId" class="pageId">
				    		<input type="hidden" id="pageNumber" value="1">
				    		<?php 
				    			if(isset($_REQUEST['PAGE_NUM'])){
				    				$numpage = $_REQUEST['PAGE_NUM'];
				    				$num = 1;
				    				for ($i=0; $i < $numpage; $i++) { 
				    		?>
						    	<a class="service_pageno" href="javascript:void(0)" id="<?php echo $num;?>"><?php echo $num;?></a>
						    <?php 
						    		$num++;
							    	}
								}
						    ?>
						</div>
			    	</div>
				</div>
			</div>
			<?php require_once "footer.php"; ?>
		</div>
	</body>
	<script src="js/jquery-3.5.1.min.js"></script>


	<script src="js/bootstrap/bootstrap.js"></script>


	<script src="js/main.js"></script>
	
</html>	