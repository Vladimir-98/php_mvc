	<div class="menu-open">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</div>

	<div class="side-menu-wrapper">
		<a href="javascript:void(0)" class="menu-close"><i class="fa fa-times" aria-hidden="true"></i></a>
		<div><a href="index"><h6 class="display-4">DETCAR</h6></a>
			<p class="p_index">Доверь своё авто профессионалам!</p>
		</div>
		<ul class="main_menu">
		    <li class="menu-children" ><a href="index">ГЛАВНАЯ</a></li>
		    <li class="menu-children" ><a href="cars">УСЛУГИ</a></li>
		    <li class="reg-btn-box" id="user_box">
		        <?php
		          $online = $_REQUEST['ONLINE'];
				  $USER = null;
				  if($online){
				    $USER = $_REQUEST['USER'];
				  }
			        if($online){
			      ?>
		        <a type="submit" class="btn" href="logout">выход</a>
	   			<a type="button" class="btn reg" href="profile?id=<?php echo $USER->id; ?>">
					личный кабинет
				</a>
		        <?php
				    }else{
				?>
					<a type="button" class="btn" href="#" data-toggle="modal" data-target="#auth">вход</a>
		        	<a type="button" class="btn reg" href="#" data-toggle="modal" data-target="#reg">регистрация</a>
				<?php
				    }
		        ?>
		    </li>
		    <li class="social-box menu-children mb-3">
		        <a class="social" href="#"><i class="fab fa-instagram"></i></a>
		        <a class="social" href="#"><i class="fab fa-youtube"></i></a>
		        <a class="social" href="#"><i class="fab fa-facebook-square"></i></a>
		        <a class="social" href="#"><i class="fab fa-vk"></i></a>
		    </li>
		    <li>
		    	<form class="d-flex" action="searchresult" method="get">
			        <input class="me_2" type="search" placeholder="поиск" aria-label="Search" name="key" id="keySearch" value="<?php if(isset($_GET['key'])){ echo $_GET['key']; }?>" autocomplete="off">
			        <button class="btn_search btn" type="submit"><i class="fas fa-search"></i></button>
		        </form>
		    </li>

		</ul>
	</div>

	<!-- Modal auth -->
	<div class="modal fade" id="auth" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<div class="alert_success" id="success_alert_id">							  
				 <form  method="post">
				  <div class="form-group">
				    <label for="email">Электронная почта</label>
				    <input type="email" name="email" class="form-control" id="email_id" aria-describedby="emailHelp">
				    <div class="alert alert_danger" id="error_email_id" style="display: none;">							  
					</div>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Пароль</label>
				    <input type="password" name="password" class="form-control" id="password_id">
				    <div class="alert alert_danger" id="error_password_id" style="display: none;">							  
					</div>
				  </div>
			      <div class="reg-btn-box">
			        <a type="button" class="btn" data-dismiss="modal">отмена</a>
			        <a type="button" class="btn" onclick="login()">войти</a>
			      </div>
				</form>
			</div>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal reg -->
	<div class="modal fade" id="reg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Регистрация</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div id="success_reg">
	        	<form action="toregister" method="post">
				  <div class="form-group">
				    <label for="exampleInputEmail1">Адрес электронной почты *</label>
				    <input type="email" name="email" class="form-control" id="email_reg" aria-describedby="emailHelp">
				    <div class="alert alert_danger" id="reg_email_id" style="display: none;">							  
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Пароль *</label>
				    <input type="password" name="password" class="form-control" id="password_reg">
				    <div class="alert alert_danger" id="reg_password_id" style="display: none;">							  
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Повторите пароль *</label>
				    <input type="password" name="repassword" class="form-control" id="re_password_reg">
				    <div class="alert alert_danger" id="reg_repassword_id" style="display: none;">							  
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputText1">Имя *</label>
				    <input type="text" name="name" class="form-control" id="name_reg">
				    <div class="alert alert_danger" id="reg_name_id" style="display: none;">							  
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputNumber1">Телефон</label>
				    <input type="number" name="number_phone" class="form-control" id="phone_reg">
				  </div>
				  	<small id="emailHelp" class="form-text text-muted">Обязательные поля для заполнения *</small>
				      <div class="reg-btn-box">
				        <a type="button" class="btn" data-dismiss="modal">отмена</a>
				        <a type="button" class="btn" onclick="register()">зарегистрировать</a>
				      </div>
				</form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

