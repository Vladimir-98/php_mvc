<?php
	namespace controllers;
	use core\User as UserAuthCheck;
	use core\Controller;
	use core\DBManager;
	use models\User;
	use models\UserModel;
	use models\Service;
	use models\ServiceModel;
	use core\FileUpload;
	use models\Reviews;
	use models\ReviewsModel;

	class MainController extends Controller{

	
		private $dbManager;
		private $authUser;
		private $userModel;
		private $serviceModel;
		private $reviewsModel;

		public function __construct(){

			$this->dbManager = new DBManager();
			$this->authUser = new UserAuthCheck();
			$this->userModel = new UserModel($this->dbManager);
			$this->serviceModel = new ServiceModel($this->dbManager);
			$this->reviewsModel = new ReviewsModel($this->dbManager);

		}

		function index(){
			$online = $this->authUser->checkOnline();
			if($online){	
				$_REQUEST['USER'] = $this->authUser->getUserData();
			}
			$_REQUEST['ONLINE'] = $online;
			return "index";
		}


		function toregister(){
			if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['name']) && isset($_POST['phone'])){
				$name = htmlspecialchars($_POST['name']);
				$phone = htmlspecialchars($_POST['phone']);
				$user = $this->userModel->getUser($_POST['email']);
				if($_POST['email']!=null){
					if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
						if($user==null || $user->id==null){
							if($_POST['password']!=null){
								if($_POST['repassword']!=null){
									if($_POST['password']===$_POST['repassword']){
										if($_POST['name']!=null){
											$user = new User();
										    $user->email = $_POST['email'];
											$user->password = sha1($_POST['password']);
											$user->name = $name;
											$user->number_phone = $phone;
											$this->userModel->addUser($user);
											$user = $this->userModel->getUser($_POST['email']);
											if($user!=null){
											$this->authUser->setUserData($user);
												echo "{\"message\":\"Добро пожаловать ".$user->name."!\", \"error\": 0, \"id\": ".$user->id."}";
											}
										}else{ echo "{\"message\":\"Введите имя\", \"error\": \"name\"}"; }
									}else{ echo "{\"message\":\"Пароли не совпадают\", \"error\": \"repassword\"}"; }
								}else{ echo "{\"message\":\"Повторите пароль\", \"error\": \"repassword\"}"; }
							}else{ echo "{\"message\":\"Введите пароль\", \"error\": \"password\"}"; }
						}else{ echo "{\"message\":\"Почта ".$user->email." уже существует!\", \"error\": \"emailFalse\"}"; }
					}else{ echo "{\"message\":\"Почта ".$_POST['email']." введена не корректно!\", \"error\": \"emailerrore\"}"; }
				}else{ echo "{\"message\":\"Почта не введена!\", \"error\": \"email\"}"; }
			}
			exit();
		}


		function ajaxAuth(){
			$user = new User();
			if(isset($_POST['user_email']) && isset($_POST['user_password'])){
				$user = $this->userModel->getUser($_POST['user_email']);
				if($user!=null && $user->id!=null){
					if($_POST['user_password']!=null){
						if($user->password===sha1($_POST['user_password'])){
							echo "{\"message\":\"Добро пожаловать ".$user->name."!\", \"error\": 0, \"id\": \"".$user->id."\"}";
							$this->authUser->setUserData($user);
						}else{ echo "{\"message\":\"Пароль не верный!\", \"error\": \"passwordIncorrect\"}"; }
					}else{ echo "{\"message\":\"Вы не ввели пароль!\", \"error\": \"passwordNull\"}"; }					
 				}else{ echo "{\"message\":\"Пользователь ".$_POST['user_email']." не найден!\", \"error\": \"emailNull\"}"; }
			}
			exit();
		}


		function saveuser(){
			if(isset($_POST['user_id']) && is_numeric($_POST['user_id']) && isset($_POST['old_email']) && isset($_POST['user_email']) && isset($_POST['user_name']) && isset($_POST['user_number']) && is_numeric($_POST['user_number'])){
				$users = $this->userModel->getUser($_POST['old_email']);
				$newEmail = $_POST['user_email'];
				$id = $_POST['user_id'];
				$name = htmlspecialchars($_POST['user_name']);
				$phone = $_POST['user_number'];
				if($newEmail!=null && $users->id === $_SESSION['CURRENT_USER']->id){
					if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
						if($name!=null){
							$user = new User();
							$user->id = $id;
						    $user->email = $newEmail;
							$user->name = $name;
							$user->number_phone = $phone;
							$this->userModel->saveUser($user);
							$user = $this->userModel->getUser($user->email);
							$this->authUser->setUserData($user);
								echo json_encode($user);
						}else{ echo "{\"message\":\"Имя не введено!\", \"error\": \"nameFalse\"}"; }
					}else{ echo "{\"message\":\"Почта ".$_POST['user_email']." введена не корректно!\", \"error\": \"emailerrore\"}"; }
				}else{ echo "{\"message\":\"Почта не введена!\", \"error\": \"emailNull\"}"; }
			}
			exit();
		}


		function savepassword(){

			if(isset($_POST['user_email']) && isset($_POST['old_password']) ?? isset($_POST['new_password']) && isset($_POST['re_new_password'])){
				$users = $this->userModel->getUser($_POST['user_email']);
				$id = $users->id;
				$email = $_POST['user_email'];
				$old_password = sha1($_POST['old_password']);
				$new_password = sha1($_POST['new_password']);
				$re_new_password = sha1($_POST['re_new_password']);
				if($users!=null && $users->id===$_SESSION['CURRENT_USER']->id){
					if($old_password!=null){
						if($old_password===$users->password){
							if($new_password!=null){
								if($new_password===$re_new_password){
									$user = new User();
									$user->id = $id;
									$user->password = $re_new_password;
									$this->userModel->savePassword($user);
									$user = $this->userModel->getUser($email);
									if($user!=null && $user->password===$re_new_password){
										 echo "{\"error\": \"0\"}"; 
									}
								}else{ echo "{\"message\":\"Пароли не совпадают!\", \"error\": \"rePasswordIncorrect\"}"; }
							}else{ echo "{\"message\":\"Введите новый пароль!\", \"error\": \"newPasswordIncorrect\"}"; }
						}else{ echo "{\"message\":\"Пароль не верный!\", \"error\": \"passwordIncorrect\"}"; }
					}else{ echo "{\"message\":\"Введите старый пароль!\", \"error\": \"passwordNull\"}"; }
				}
			}
			exit();
		}


		function toaddservice(){
				if(isset($_POST['title_service']) && isset($_POST['description_service']) && isset($_POST['text_service']) && isset($_FILES['file'])){
					$online = $this->authUser->checkOnline();
					$_REQUEST['ONLINE'] = $online;
					if($online){
						$fileUpload = new FileUpload();
						$newFileName = $_FILES['file']['name'][0];
						$newFileName1 = $_FILES['file']['name'][1];
						$newFileName2 = $_FILES['file']['name'][2];
						$newFileName = sha1($_POST['title_service']);
						$newFileName1 = sha1($_POST['title_service']);
						$newFileName2 = sha1($_POST['title_service']);
						$tmpDimension = getimagesize($_FILES['file']['tmp_name'][0]);
						$tmpDimension1 = getimagesize($_FILES['file']['tmp_name'][1]);
						$tmpDimension2 = getimagesize($_FILES['file']['tmp_name'][2]);
						if($_FILES['file']['tmp_name'][0]!=null && $_FILES['file']['size'][0]<=1024*1024 && $tmpDimension[1]>=1080 && $tmpDimension[0]>=1920){
						 	if($_FILES['file']['tmp_name'][1]!=null && $_FILES['file']['size'][0]<=1024*1024 && $tmpDimension1[1]>=1080 && $tmpDimension1[0]>=1920){
						 		if($_FILES['file']['tmp_name'][2]!=null && $_FILES['file']['size'][0]<=1024*1024 && $tmpDimension2[0]>=1080 && $tmpDimension2[1]>=1920){
									if($_POST['title_service']!=null){
									 	if($_POST['description_service']!=null){
									 		if($_POST['text_service']!=null){
									 			$img_one = $fileUpload->uploadServiceImages($newFileName."_img_one", $_FILES['file']['tmp_name'][0], $_FILES['file']['type'][0]);
												$img_two = $fileUpload->uploadServiceImages($newFileName1."_img_two", $_FILES['file']['tmp_name'][1], $_FILES['file']['type'][1]);
												$img_three = $fileUpload->uploadServiceImagesCrop($newFileName2."_img_three", $_FILES['file']['tmp_name'][2], $_FILES['file']['type'][2]);
												$service = new Service();
												$service->title = htmlspecialchars($_POST['title_service']);
												$service->description = htmlspecialchars($_POST['description_service']);
												$service->long_text = htmlspecialchars($_POST['text_service']);
												$service->img_one = $img_one; 
												$service->img_two = $img_two; 
												$service->img_three = $img_three;
												$this->serviceModel->addService($service);
												echo "{\"suc\": \"yes\"}"; 
											 }else{ echo "{\"message\":\"Поле <b>'ТЕКСТ'</b> не должно быть пустым!\", \"error\": \"6\"}"; }
										 }else{ echo "{\"message\":\"Поле <b>'ОПИСАНИЕ'</b> не должно быть пустым!\", \"error\": \"5\"}"; }
									 }else{ echo "{\"message\":\"Поле <b>'ЗАГОЛОВОК'</b> не должно быть пустым!\", \"error\": \"4\"}"; }
						 		}else{ echo "{\"message\":\"Файл <b>'".$_FILES['file']['name'][2]."'</b> некорректный!\", \"error\": \"3\"}"; }
						 	}else{ echo "{\"message\":\"Файл <b>'".$_FILES['file']['name'][1]."'</b> некорректный!\", \"error\": \"2\"}"; }
						}else{ echo "{\"message\":\"Файл <b>'".$_FILES['file']['name'][0]."'</b> некорректный!\", \"error\": \"1\"}"; }
					}
				}else{ echo "{\"message\":\"Что-то пошло не так!!!\", \"error\": \"0\"}"; }
			exit();
		}


		function uploadava(){
			$redirect = "index";
			if(isset($_FILES['avatar'])){
				if($_SESSION['CURRENT_USER']!=null){ 
					if($_FILES['avatar']['size']<=1024*1024){
						$fileUpload = new FileUpload();
						if($_FILES['avatar']['tmp_name']!=null){
							$newFileName = sha1($this->authUser->getUserData()->id."_avatar");
						}else{$newFileName = "default";}
						$largePath = $fileUpload->uploadChangedImage($newFileName."_large", 720, $_FILES['avatar']);
						$mediumPath = $fileUpload->uploadChangedImage($newFileName."_medium", 360, $_FILES['avatar']);
						$smallPath = $fileUpload->uploadChangedImage($newFileName."_small", 90, $_FILES['avatar']);
						$user = $this->authUser->getUserData();
						$user->avatar_large = $largePath;
						$user->avatar_medium = $mediumPath;
						$user->avatar_small = $smallPath;
						$this->userModel->updateAva($user);
						$this->authUser->setUserData($user);
						$redirect = "profile?id=".$user->id;
					}
				}
			}
			header("Location:$redirect");
		}

		function tosaveservice(){
			if(isset($_POST['save_title_service']) && $_POST['save_title_service']!=null){
				if(isset($_POST['save_description_service']) && $_POST['save_description_service']!=null){
					if(isset($_POST['save_text_service']) && $_POST['save_text_service']!=null){
						$online = $this->authUser->checkOnline();
						$_REQUEST['ONLINE'] = $online;
						if($online){
							$id = $_POST['service_id'];
							$currentservices = $this->serviceModel->getService($id);
							$service = new Service();
							if(isset($_FILES['file'])){
								$tmpDimension = getimagesize($_FILES['file']['tmp_name'][0]);
								$tmpDimension1 = getimagesize($_FILES['file']['tmp_name'][1]);
								$tmpDimension2 = getimagesize($_FILES['file']['tmp_name'][2]);
								if($_FILES['file']['tmp_name'][0]!="" && $_FILES['file']['size'][0]<=1024*1024 && $tmpDimension[1]>=1080 && $tmpDimension[0]>=1920){
								 	if($_FILES['file']['tmp_name'][1]!="" && $_FILES['file']['size'][0]<=1024*1024 && $tmpDimension1[1]>=1080 && $tmpDimension1[0]>=1920){
								 		if($_FILES['file']['tmp_name'][2]!="" && $_FILES['file']['size'][0]<=1024*1024 && $tmpDimension2[0]>=1080 && $tmpDimension2[1]>=1920){
								 			unlink("uploads/service/".$currentservices->img_one);
								 			unlink("uploads/service/".$currentservices->img_two);
								 			unlink("uploads/service/".$currentservices->img_three);
								 			$fileUpload = new FileUpload();
													$newFileName = $_FILES['file']['name'][0];
													$newFileName1 = $_FILES['file']['name'][1];
													$newFileName2 = $_FILES['file']['name'][2];
													$newFileName = sha1($_POST['save_title_service']."_save");
													$newFileName1 = sha1($_POST['save_title_service']."_save");
													$newFileName2 = sha1($_POST['save_title_service']."_save");
										 			$img_one = $fileUpload->uploadServiceImages($newFileName."_img_one", $_FILES['file']['tmp_name'][0], $_FILES['file']['type'][0]);
													$img_two = $fileUpload->uploadServiceImages($newFileName1."_img_two", $_FILES['file']['tmp_name'][1], $_FILES['file']['type'][1]);
													$img_three = $fileUpload->uploadServiceImagesCrop($newFileName2."_img_three", $_FILES['file']['tmp_name'][2], $_FILES['file']['type'][2]);
								 			}else{ echo "{\"message\":\"Файл <b>'".$_FILES['file']['name'][2]."'</b> некорректный!\", \"error\": \"3\"}"; }
								 	}else{ echo "{\"message\":\"Файл <b>'".$_FILES['file']['name'][1]."'</b> некорректный!\", \"error\": \"2\"}"; }
								}else{ echo "{\"message\":\"Файл <b>'".$_FILES['file']['name'][0]."'</b> некорректный!\", \"error\": \"1\"}"; }
							}else{
								$img_one = $currentservices->img_one;
								$img_two = $currentservices->img_two;
								$img_three = $currentservices->img_three;
							}
								$service->id = $id;
								$service->title = htmlspecialchars($_POST['save_title_service']);
								$service->description = htmlspecialchars($_POST['save_description_service']);
								$service->long_text = htmlspecialchars($_POST['save_text_service']);
								$service->img_one = $img_one; 
								$service->img_two = $img_two; 
								$service->img_three = $img_three;
								$this->serviceModel->updateService($service);
								$service = $this->serviceModel->getService($service->id);
								echo json_encode($service);
							}
						}else{ echo "{\"message\":\"Поле 'ТЕКСТ' не должно быть пустым!\", \"error\": \"error\"}"; }
				    }else{ echo "{\"message\":\"Поле 'ОПИСАНИЕ' не должно быть пустым!\", \"error\": \"error\"}"; }
			    }else{ echo "{\"message\":\"Поле 'ЗАГОЛОВОК' не должно быть пустым!\", \"error\": \"error\"}"; }
			exit;
		}



		function logout(){
			$this->authUser->removeUserData();
			header("Location:index");
		}

		function profile(){
			$redirect = "index";
			$online = $this->authUser->checkOnline();
			if($online){			
				$_REQUEST['USER'] = $this->authUser->getUserData();
			}
			$_REQUEST['ONLINE'] = $online;
			if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']===$_SESSION['CURRENT_USER']->id){
				$redirect = "profile";
			}
			return $redirect;
		}


		function cars(){
			$numpage = $this->serviceModel->getPageno();
			$_REQUEST['PAGE_NUM'] = $numpage;
			$online = $this->authUser->checkOnline();
			if($online){			
				$_REQUEST['USER'] = $this->authUser->getUserData();
			}
			$_REQUEST['ONLINE'] = $online;

			return "cars";

		}


		function detailcar(){
			$redirect = "index";
			$online = $this->authUser->checkOnline();
			if($online){	
				$_REQUEST['USER'] = $this->authUser->getUserData();
			}
			$_REQUEST['ONLINE'] = $online;

			if(isset($_GET['id']) && is_numeric($_GET['id'])){
				$id = $_GET['id'];
				$service = $this->serviceModel->getService($id);
				$_REQUEST['SERVICE'] = $service;
				$redirect = "detailcar";
			}
			 return $redirect;
		}


		function todeleteservice(){
			if(isset($_POST['id_service']) && is_numeric($_POST['id_service'])){
				$id = $_POST['id_service'];
				$online = $this->authUser->checkOnline();
				$this->serviceModel->toDeleteService($id);
			}
			header("Location:cars");
		}


		function toaddreviews(){
			if(isset($_POST['service_reviews_id']) && isset($_POST['reviews_text']) && is_numeric($_POST['service_reviews_id'])){
				$reviews_id = $_POST['service_reviews_id'];
				$reviews = htmlspecialchars($_POST['reviews_text']);
				$online = $this->authUser->checkOnline();
				if($online){	
					$_REQUEST['USER'] = $this->authUser->getUserData();
					if($_POST['reviews_text']!=null){
						if($_SESSION['CURRENT_USER']!=null){
						$review = new Reviews();
						$review->service_id = $reviews_id;
						$review->user_id = $_SESSION['CURRENT_USER']->id;
						$review->review = $reviews;
						$this->reviewsModel->addReview($review);
						$this->serviceModel->updateserviceReview($reviews_id);
						$service = $this->serviceModel->getService($reviews_id);
						echo "{\"error\": \"0\", \"service\": \"".$service->reviews_num."\"}"; 
						}
					}else{ echo "{\"error\": \"1\"}"; }
				}else{ echo "{\"error\": \"2\"}"; }
			}
			exit();
		}


		function getallreviews(){
			if(isset($_GET['id']) && is_numeric($_GET['id'])){
				$id = $_GET['id'];
				$reviews = $this->reviewsModel->getAllReviews($id);
				echo json_encode($reviews);
			}else{ echo "{\"error\": \"0\"}"; }
		exit();
		}


		function getallservices(){
			if (isset($_GET['page'])){
				$page = $_GET['page'];
			}else {
				$page = 1;
			}
			$key = "";
			$sortService = "";
			if(isset($_GET['sortService'])){
				$sortService = $_GET['sortService'];
			}
			

			if(isset($_GET['key'])){
				$key = htmlspecialchars($_GET['key']);
			}
			$service = $this->serviceModel->getAllServices($key, $sortService, $_GET['page']);
			
			echo json_encode($service);
		exit();

		}

		// function getnumpage(){
		// 	if (isset($_GET['page'])){
		// 			$page = $_GET['page'];
		// 	}else $page = 1;
		// 	$numpage = $this->serviceModel->getNumPage();
		// 	$numpage = $__SESSION['PAGE_NUM'];
		// 	exit();
		// }

		function searchresult(){
			if(isset($_GET['key'])){
				$key = $_GET['key'];
			}
		header("Location:cars?key=".$key);
		}
		
	
	}
?>