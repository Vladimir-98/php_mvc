<?php 
	
	namespace models;
	use models\Service;
	use core\DBManager;
	use PDO;

	class ServiceModel{

		private $dbManager;

		public function __construct($dbManager){
			$this->dbManager = $dbManager;
		}




		function getAllServices($key="", $sortServise=false, $page=false){
			$kol = 2; 
			$art = ($page * $kol)-$kol; 
			$result = null;
			if($sortServise == "sortReviews"){
				$sql = " SELECT * FROM service WHERE title LIKE :title ORDER BY reviews_num DESC LIMIT ".$art.",".$kol."";
			}else if($sortServise == "sortDate"){
				$sql = " SELECT * FROM service WHERE title LIKE :title ORDER BY date_service ASC LIMIT ".$art.",".$kol."";
			}else if($sortServise == "sortName"){
				$sql = " SELECT * FROM service WHERE title LIKE :title ORDER BY title ASC LIMIT ".$art.",".$kol."";
			}else{
				$sql = " SELECT * FROM service WHERE title LIKE :title ORDER BY id DESC LIMIT ".$art.",".$kol."";
			}
			try{

				$query = $this->dbManager->getConnection()->prepare("".$sql."");
				$query->execute(array("title"=>"%".$key."%"));
				$result = $query->fetchAll(PDO::FETCH_CLASS, "models\Service");

			}catch(PDOException $e){
				echo $e->getMessage();
			}
			return $result;
		}

		function getService($id){
			$result = null;
			try{

				$query = $this->dbManager->getConnection()->prepare("SELECT * FROM service WHERE id =:id");
				$query->execute(array("id"=>$id));
				$query->setFetchMode(PDO::FETCH_CLASS, "models\Service");
				$result = $query->fetch();

			}catch(PDOException $e){
				echo $e->getMessage();
			}
			return $result;
		}



		function addService($service){

			try{

				$query = $this->dbManager->getConnection()->prepare("
					INSERT INTO service (title, description, long_text, img_one, img_two, img_three) 
					VALUES (:title, :description, :long_text, :img_one, :img_two, :img_three)
				");
				$query->execute(array("title"=>$service->title, "description"=>$service->description, "long_text"=>$service->long_text, "img_one"=>$service->img_one, "img_two"=>$service->img_two, "img_three"=>$service->img_three));
				
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}


		function updateService($service){

			try{

				$query = $this->dbManager->getConnection()->prepare("
					UPDATE service SET id = :id, title = :title, description = :description, long_text = :long_text, img_one = :img_one, img_two = :img_two, img_three = :img_three
					WHERE id = :id
				");
				$query->execute(array("id"=>$service->id, "title"=>$service->title, "description"=>$service->description, "long_text"=>$service->long_text, "img_one"=>$service->img_one, "img_two"=>$service->img_two, "img_three"=>$service->img_three));
				
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}

		function updateserviceReview($reviews_id){

			try{

				$query = $this->dbManager->getConnection()->prepare("
					UPDATE service SET reviews_num = reviews_num+1
					WHERE id = :id
				");

				$query->execute(
					array("id"=>$reviews_id)
				);

			}catch(Exception $e){
				echo $e->getMessage();
			}
		}


		function toDeleteService($id){

			try{

				$query = $this->dbManager->getConnection()->prepare("
					DELETE FROM service 
					WHERE id = :id
				");
				$query->execute(array("id"=>$id));
				
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}

		function getPageno(){
			$result = array();
			try{

				$query = $this->dbManager->getConnection()->prepare("SELECT COUNT(*) FROM service");
				$query->execute();
				$num = $query->fetch(MYSQLI_NUM);
				$result = implode($num)/2;

			}catch(PDOException $e){
				echo $e->getMessage();
			}
			return $result;
		}

		
	}


?>