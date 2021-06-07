<?php 
	
	namespace core;

	class FileUpload{	
	
		function uploadChangedImage($newName, $newWidth, $file){

			$fileType = "jpg";

			$tmpDimension = getimagesize($file['tmp_name']);

			$oldWidth = $tmpDimension[0];

			$oldHeight = $tmpDimension[1];

			$newHeight = ($newWidth*$oldHeight)/$oldWidth;

			$newImage = imagecreatetruecolor($newWidth,$newHeight);

			if($file['type']=='image/jpeg'){

				$fileType = "jpg";

				$source = imagecreatefromjpeg($file['tmp_name']);

				imagecopyresized($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);

				imagejpeg($newImage, "uploads/".$newName.".".$fileType);

			}




			else if($file['type']=='image/png'){

				$fileType = "png";

				$source = imagecreatefrompng($file['tmp_name']);

				imagecopyresized($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);

				imagepng($newImage, "uploads/".$newName.".".$fileType);

			}

			return $newName.".".$fileType;

		}

		function uploadServiceImages($newName, $file, $type){

			$oldImages = imagecreatefromjpeg($file);
			$newImages = imagecrop($oldImages, ['x' => 0, 'y' => 0, 'width' => 1920, 'height' => 1080]);
			$newWidth = 768;
			$newHeight = 432;
			$newImages = imagecreatetruecolor($newWidth,$newHeight);
			$fileType = "jpg";
			if($type=='image/jpeg'){
				$fileType = "jpg";
				$source = imagecreatefromjpeg($file);
				imagecopyresized($newImages, $source, 0, 0, 0, 0, $newWidth, $newHeight, 1920, 1080);
				imagejpeg($newImages, "uploads/service/".$newName.".".$fileType);
			}
			return $newName.".".$fileType;
		}

		function uploadServiceImagesCrop($newName, $file, $type){

			$oldImages = imagecreatefromjpeg($file);
			$newImages = imagecrop($oldImages, ['x' => 0, 'y' => 0, 'width' => 1080, 'height' => 1602]);
			$newWidth = 768;
			$newHeight = 1139;
			$newImages = imagecreatetruecolor($newWidth,$newHeight);
			$fileType = "jpg";
			if($type=='image/jpeg'){
				$fileType = "jpg";
				$source = imagecreatefromjpeg($file);
				imagecopyresized($newImages, $source, 0, 0, 0, 0, $newWidth, $newHeight, 1080, 1602);
				imagejpeg($newImages, "uploads/service/".$newName.".".$fileType);
			}
			return $newName.".".$fileType;
		}

	}


?>