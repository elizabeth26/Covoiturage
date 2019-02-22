<?php
class Etudiant{
	private $per_obj;
	private $dep_num;
	private $div_num;

	public function __construct($per_obj,$valeurs_etu){
		if (!empty($valeurs_etu))
				 $this->affecte($per_obj,$valeurs_etu);
	}
	public function affecte($per_obj,$valeurs_etu){
		$this->setPersObj($per_obj);
				foreach ($valeurs_etu as $attribut => $valeur){
						switch ($attribut){
								case 'dep_num': $this->setDepNum($valeur); break;
							  case 'div_num': $this->setDivNum($valeur); break;
						}
				}
		}

		public function getPersObj() {
		        return $this->per_obj;
		}
		public function setPersObj($per_obj){
		        $this->per_obj=$per_obj;
		}

		public function getDepNum() {
		        return $this->dep_num;
		}
		public function setDepNum($dep_num){
				if(is_numeric($dep_num)){
					$this->dep_num=$dep_num;
			}
		}

		public function getDivNum() {
		        return $this->div_num;
		}
		public function setDivNum($div_num){
			if(is_numeric($div_num)){
				 $this->div_num=$div_num;
			}
		}
}
	?>
