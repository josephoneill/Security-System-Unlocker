<?php
    class Chip {
		private $firstColor;
		private $secondColor;
		private $used;

   		function __construct($firstColor, $secondColor) {
			$this->firstColor = $firstColor;
			$this->secondColor = $secondColor;
			$this->used = false;
		}

        public function setFirstColor($firstColor) { 
			$this->firstColor = $firstColor;  
 		}
 
   		public function getFirstColor() {
			return $this->firstColor;
        }
        
        public function setSecondColor($secondColor) { 
			$this->firstColor = $secondColor;  
 		}
 
   		public function getSecondColor() {
			return $this->secondColor;
		}

		public function setUsed($used) {
			$this->used = $used;
		}

		public function isUsed() {
			return $this->used;
		}
		
	}
?>