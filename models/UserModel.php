<?php 
	
	namespace models;
	use models\User;
	use core\DBManager;
	use PDO;

	class UserModel{

		private $dbManager;

		public function __construct($dbManager){
			$this->dbManager = $dbManager;
		}

		public function addUser($user){

			try {
				
				$query = $this->dbManager->getconnection()->prepare("
					INSERT INTO users (email, password, name, number_phone)
					VALUES (:email, :password, :name, :number_phone)
					");
				$query->execute(array("email"=>$user->email, "password"=>$user->password, "name"=>$user->name, "number_phone"=>$user->number_phone));

			} catch (PDOException $e) {

				echo $e->getMessage();
			}

		}

		public function getUser($email){
			$result = null;
			try{

				$query = $this->dbManager->getConnection()->prepare("SELECT * FROM users WHERE email =:email");
				$query->execute(array("email"=>$email));
				$query->setFetchMode(PDO::FETCH_CLASS, "models\User");
				$result = $query->fetch();

			}catch(PDOException $e){
				echo $e->getMessage();
			}
			return $result;
		}


		public function saveUser($user){
			
			try{

				$query = $this->dbManager->getConnection()->prepare("

					UPDATE users SET email = :email, name = :name, number_phone = :phone
					WHERE id = :id

					");
				$query->execute(array("id"=>$user->id, "email"=>$user->email, "name"=>$user->name, "phone"=>$user->number_phone));

				
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			
		}

		public function savePassword($user){
			
			try{

				$query = $this->dbManager->getConnection()->prepare("

					UPDATE users SET password = :password
					WHERE id = :id

					");
				$query->execute(array("id"=>$user->id, "password"=>$user->password));

				
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			
		}


		function updateAva($user){

			try{

				$query = $this->dbManager->getConnection()->prepare("
					UPDATE users SET avatar_large = :avatar_large, avatar_medium = :avatar_medium, avatar_small = :avatar_small 
					WHERE id = :id
				");
				$query->execute(array("avatar_large"=>$user->avatar_large, "avatar_medium"=>$user->avatar_medium, "avatar_small"=>$user->avatar_small, "id" =>$user->id));
				
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}

	}


?>