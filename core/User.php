<?php
	namespace core;

	class User{

		function __construct(){

			session_start();

		}

		public function checkOnline(){			/*online offline*/

			return isset($_SESSION['CURRENT_USER']);

		}

		public function getUserData(){			/*current data*/

			if($this->checkOnline()){
				return $_SESSION['CURRENT_USER'];
			}else{
				return null;
			}

		}

		public function setUserData($userData){

			$_SESSION['CURRENT_USER'] = $userData;

		}

		public function removeUserData(){

			$_SESSION['CURRENT_USER'] = null;
			session_destroy();

		}



	}
?>