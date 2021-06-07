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
		
		<title>profile</title>
		<?php require_once "head.php"; ?>
	</head>
	<body>
		<div class="container-fluid p-0">
			<?php require_once "navbar.php"; ?>		

			<div class="container p-0 mt-5">
			<?php
				if($online && $USER->id===$_GET['id']){
			?>
				<div class="row">
					<div class="col-sm-4">
						<div class="profile_title">
							<h1>Личный кабинет <br><?php echo $USER->name; ?></h1>
						</div>
						<div class="main_card">
							<div class="card_body">
								<?php
								  $avaLarge = (isset($USER->avatar_large) && $USER->avatar_large!=""?$USER->avatar_large:"default_large.jpg");
								?>
								<div class="profile_img_box">
								<img src="uploads/<?php echo $avaLarge;?>" class="card-img-top">
							    <form action="uploadava" method="post" enctype="multipart/form-data">
									<div class="fileform">
										<input class="avatar" type="file" name="avatar" id="upload" />
									</div>	
									<div class="row mt-3">
										<div class="col-12">
											<button class="btn">загрузить</button>
										</div>
									</div>
								</form>
							</div> 
							</div>
						</div> 
						<!-- <div class="profile_menu">
							<ul class="profile_ul">
								<li class="menu-children"><a href="cars.php">НАСТРОЙКИ</a></li>
							    <li class="menu-children"><a href="#">КОММЕНТАРИИ</a></li>
							    <li class="menu-children"><a href="#">СООБЩЕНИЯ</a></li>

							</ul>
						</div> -->
					</div>
					<div class="col-sm-8 profile_col">
						<div class="settings_title">
							<h2>Информация</h2>
						</div>
						<form>
						  <div class="form-group">
						  	<input type="hidden" id="old_email" value="<?php echo $USER->email; ?>">
						  	<input type="hidden" id="user_id" value="<?php echo $USER->id; ?>">
						    <label for="exampleInputEmail1">почта *</label>
						    <input type="email" class="form-control" id="email_save" aria-describedby="emailHelp" value="<?php echo $USER->email; ?>">
						    <div class="alert alert_danger" id="error_email_save" style="display: none;">							  
							</div>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputEmail1">имя *</label>
						    <input type="text" class="form-control" id="name_save" aria-describedby="emailHelp" value="<?php echo $USER->name; ?>">
						    <div class="alert alert_danger" id="error_name_save" style="display: none;">							  
							</div>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputEmail1">телефон</label>
						    <input type="tel" class="form-control" id="number_phone" aria-describedby="emailHelp" value="<?php echo $USER->number_phone; ?>">

						  	<small id="emailHelp" class="form-text text-muted mt-3">Обязательные поля для заполнения *</small>
						  </div>
						  <div class="settings_btn">
						  	<div class="dataUpdate" id="dataUpdate" style="display: none;">
						  	  <span>Данные обновлены!</span>
						  	</div>
							  <button type="button" class="btn ml-auto" onclick="saveUser()">изменить</button>
						  </div>
						</form>
						<div class="settings_title">
							<h2>Пароль</h2>
						</div>

						<form>
						  <div class="form-group">
						  	<input type="hidden" id="user_password_email" value="<?php echo $USER->email; ?>">
						    <label for="exampleInputPassword1">введите старый пароль *</label>
						    <input type="password" class="form-control" id="oldPassword">
						    <div class="alert alert_danger" id="error_password_save" style="display: none;"></div>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">введите новый пароль *</label>
						    <input type="password" class="form-control" id="newPassword">
						    <div class="alert alert_danger" id="error_new_password_save" style="display: none;"></div>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">повторите новый пароль *</label>
						    <input type="password" class="form-control" id="reNewPassword">
						    <div class="alert alert_danger" id="error_re_password_save" style="display: none;"></div>
						    <small id="emailHelp" class="form-text text-muted mt-3">Обязательные поля для заполнения *</small>
						  </div>
							  <div class="settings_btn">
							  	<div class="dataUpdate" id="passwordUpdate" style="display: none;">
							  	  <span>Пароли обновлены!</span>
							  	</div>
							  	<button type="button" class="btn ml-auto" onclick="savepassword()">изменить</button>
							  </div>
						</form>
					</div>
				</div>
			<?php
				}else{
			?>
				
				<div class="profile_title">
					<h1 class="display-4">Страница не существует, <br>проверьте адрес.</h1>
				</div>

			<?php
				}
			?>
			</div>
		</div>
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="js/bootstrap/bootstrap.min.js"></script>

	<script src="js/main.js"></script>
	
</html>	