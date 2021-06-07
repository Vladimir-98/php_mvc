<?php
	namespace core;

	class Controller{

		public function process(){

			if(isset($_GET['act'])){

				return $this->{$_GET['act']}();

			}else{

				return $this->{"index"}();
				
			}
		}
	}
?>