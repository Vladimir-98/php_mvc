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
		<title>Детейлинг центр</title>
		<?php require_once "head.php"; ?>
	</head>
	<body>
		<div class="container-fluid p-0">
			<?php require_once "navbar.php"; ?>
			<div class="container p-0 mt-5">
			<?php
				$service = $_REQUEST['SERVICE'];
				if($service!=null){
			?>
				<div class="h1_title" id="h1_title">
					<h1 class="page_title display-4" id="page_title"><?php echo $service->title; ?></h1>
				</div>
				<?php if(isset($_REQUEST['USER']) && $USER->email == "super.admin@mail.kz"){?>
				<button type="button" class="btn_white btn" data-toggle="modal" data-target="#saveCar" id="buttonSaveCar" <?php if(!$online){ echo 'style="display: none;"';} ?>>изменить</button>
				<!-- Modal update -->
				<div class="modal fade" id="saveCar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-xl">
				    <div class="modal-content" id="save_data_id">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Редактирование</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
						<div class="alert_success" id="success_alert_id">							  
							 <form  enctype="multipart/form-data" >
							 	<div class="row">
							 		<div class="col-sm-8 mx-auto">
							 			<div class="row mt-5">
											<div class="col-sm-7 mx-auto">
												<a class="new_img cars_img_left" id="img_one"><img src="uploads/service/<?php echo $service->img_one; ?>" alt="">1</a>	
												<a class="new_img cars_img_left" id="img_two"><img src="uploads/service/<?php echo $service->img_two; ?>" alt="">2</a>
											</div>
											<div class="col-sm-5">
												<a class="new_img cars_img_right" id="img_three"><img src="uploads/service/<?php echo $service->img_three; ?>" alt="">3</a>
											</div>
										</div>
										<div class="row">
											<div class="fileform mb-2 m-5 mx-auto">
												<input class="avatar" type="file" name="file[]" id="file" multiple>
											</div>
										</div>
							 		</div>
							 	</div>
							  <div class="form-group">
							    <label for="email">ЗАГОЛОВОК</label>
							    <input type="hidden" name="service_id" class="form-control" id="service_id" aria-describedby="emailHelp" value="<?php echo $service->id; ?>">
							    <input type="text" name="save_title_service" class="form-control" id="save_title_service" aria-describedby="emailHelp" value="<?php echo $service->title; ?>">
							    <div class="alert alert_danger" id="title" style="display: none;">							  
								</div>
							  </div>
							  <div class="form-group">
							    <label for="exampleInputPassword1">ОПИСАНИЕ</label>
							    <input type="text" name="save_description_service" class="form-control" id="save_description_service" value="<?php echo $service->description; ?>">
							    <div class="alert alert_danger" id="description" style="display: none;">							  
								</div>
							  </div>
							  <div class="form-group">
							    <label for="exampleInputPassword1">ТЕКСТ</label>
							    <textarea  type="text" name="save_text_service" class="form-control" id="save_text_service"><?php echo $service->long_text; ?></textarea>
							    <div class="alert alert_danger" id="text" style="display: none;">							  
								</div>
							  </div>
						      <div>
						        <a type="button" class="btn" data-dismiss="modal">отмена</a>
						        <button type="button" class="btn_white btn" id="saveService">изменить</button>
						        <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteCar">удалить</a>
						      </div>
							</form>
							<div class="alert alert_danger" id="save_form_error">							  
							</div>
						</div>
				      </div>
				    </div>
				  </div>
				</div>

					<!-- Modal delete -->
				<div class="modal fade" id="deleteCar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">	ВЫ УВЕРЕНЫ?</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
						<div class="alert_success" id="success_alert_id">							  
							 <form  method="post" action="todeleteservice">
							 	<input type="hidden" name="id_service" class="form-control" value="<?php echo $service->id; ?>">
						      <div class="reg-btn-box">
						        <a type="button" class="btn" data-dismiss="modal">отмена</a>
						        <button type="submit" class="btn btn-danger">удалить</button>
						      </div>
							</form>
						</div>
				      </div>
				    </div>
				  </div>
				</div>
				<?php }?>
				
				<div class="row element-box">
	                <div class="col-sm-4 mt-5">
	                    <div class="element-icon style2">
	                        <div class="icon"><i class="fa fa-check" aria-hidden="true"></i></div>
	                        <div class="content">
	                            <h4 class="title">сроки</h4>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-sm-4 mt-5">
	                    <div class="element-icon style2">
	                        <div class="icon"><i class="fa fa-check" aria-hidden="true"></i></div>
	                        <div class="content">
	                            <h4 class="title">гарантия</h4>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-sm-4 mt-5">
	                    <div class="element-icon style2">
	                        <div class="icon"><i class="fa fa-check" aria-hidden="true"></i></div>
	                        <div class="content">
	                            <h4 class="title">результат</h4>
	                        </div>
	                    </div>
	                </div>
	            </div>
				<div class="row mt-5">
					<div class="col-sm-6 p-2">
						<a class="banner-border cars_img_left" id="cars_img_left"><img src="uploads/service/<?php echo $service->img_one; ?>" alt=""></a>
					</div>
					<div class="col-sm-6 p-2">
						<div id="reviews" class="box_reviews p-3">
							<p><?php echo $service->long_text; ?></p>
						</div>
					</div>
				</div>
				<div class="reviews mt-5">
					<h3 class="reviews_list_title display-4" id="reviews_num"><?php if($service->reviews_num==0){ echo "Отзывов пока нет ";}else if($service->reviews_num==1){ echo $service->reviews_num." отзыв"; }else{ echo $service->reviews_num." отзывов"; } ?></h3>
					<div class="reviews_item mt-5">
						<div class="row">
							<div class="col-sm-8 mx-auto">
				        		<input type="hidden" id="service_reviews_id" value="<?php echo $service->id; ?>">
		                		<div id="loadreviews">
								 	<textarea type="text" id="reviews_text" class="form-control form_reviews"></textarea>
								 		<label class="form_reviews">Отзывы могут оставлять только зарегистрированные пользователи.</label>
							        <div class="reg-btn-box">
								        <button type="button" class="btn mt-3 ml-auto" id="addreviews">отправить</button>
								    </div>
		                		</div>
		                	</div>
						</div>
	                    <div class="row">
	                    	<div class="col-sm-12">
	                    		<div id="box_reviews_result">
			        	    	</div>
	                    	</div>
	                    </div>
	    	    	</div>
				</div>

			<?php
				}else{
			?>
				<div class="profile_title">
					<h1 class="display-4">Услуга не найдена, <br>проверьте адрес.</h1>
				</div>
			<?php
				}
			?>
			</div>

		</div>
	</div>
	</body>
	<script src="js/jquery-3.5.1.min.js"></script>


	<script src="js/bootstrap/bootstrap.min.js"></script>


	<script src="js/main.js"></script>
	
</html>	