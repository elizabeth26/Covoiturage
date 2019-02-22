<?php
class Parcours{
	private	 $par_num;
	private	 $ville1;
	private  $ville2;
	private $nbKm;

	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
								case 'par_num': $this->setParnum($valeur); break;
								case 'par_km': $this->setNbKm($valeur); break;
								case 'vil_num1': $this->setVille1($valeur); break;
								case 'vil_num2': $this->setVille2($valeur); break;
						}
				}
		}
		public function getParnum() {
						return $this->par_num;
				}
		public function setParnum($par_num){
				if(is_numeric($par_num)){
					$this->par_num=$par_num;
				}
		}

		public function getVille1() {
		        return $this->ville1;
		}

		public function setVille1($ville1){
				if(is_numeric($ville1)){
					$this->ville1=$ville1;
				}
	 	}

		public function getVille2() {
		        return $this->ville2;
		}
		public function setVille2($ville2){
			if(is_numeric($ville2)){
			 $this->ville2=$ville2;
			}
		}

		public function getNbKm() {
		        return $this->nbKm;
		}
		public function setNbKm($nbKm){
			if(is_numeric($nbKm)){
				$this->nbKm=$nbKm;
			}
		}



}
