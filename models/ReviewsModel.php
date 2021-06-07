<?php 
	
	namespace models;
	use models\Reviews;
	use core\DBManager;
	use PDO;

	class ReviewsModel{

		private $dbManager;

		public function __construct($dbManager){
			$this->dbManager = $dbManager;
		}

		public function addReview($review){

			try{

				$query = $this->dbManager->getConnection()->prepare("
					INSERT INTO reviews (service_id, user_id, review) 
					VALUES (:service_id, :user_id, :review)
				");
				$query->execute(array("service_id"=>$review->service_id, "review"=>$review->review, "user_id"=>$review->user_id));
				
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}

		function getAllReviews($id){

			$result = array();
			try{

				$query = $this->dbManager->getConnection()->prepare("
					SELECT r.id, r.service_id, r.user_id, r.review, r.data_review, u.avatar_small, u.name 
					FROM reviews r 
					INNER JOIN users u ON u.id = r.user_id
					WHERE r.service_id = $id
					ORDER BY r.id DESC
				");
				$query->execute();
				$result = $query->fetchAll(PDO::FETCH_CLASS, "models\Reviews");

			}catch(PDOException $e){
				echo $e->getMessage();
			}
			return $result;

		}

		
	}


?>