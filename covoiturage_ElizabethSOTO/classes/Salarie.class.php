<?php
class Salarie{
	private $per_obj;
	private $sal_telprof;
	private $fon_num;

	public function __construct($per_obj,$valeurs_sal){
		if (!empty($valeurs_sal))
				 $this->affecte($per_obj,$valeurs_sal);
	}

	public function affecte($per_obj,$valeurs_sal){
		$this->setPerObj($per_obj);

				foreach ($valeurs_sal as $attribut => $valeur){
						switch ($attribut){
								case 'sal_telprof': $this->setTelprof($valeur); break;
							  case 'fon_num': $this->setFonNum($valeur); break;
						}
				}
		}

		public function getPerObj() {
		        return $this->per_obj;
		}
		public function setPerObj($per_obj){
		        $this->per_obj=$per_obj;
	  }

		public function getTelprof() {
		        return $this->sal_telprof;
		}
		public function setTelprof($sal_telprof){
		        $this->sal_telprof=$sal_telprof;
		}

		public function getFonNum() {
		        return $this->fon_num;
		}
		public function setFonNum($fon_num){
			if(is_numeric($fon_num)){
				 $this->fon_num=$fon_num;
			}
		}
}
	?>
