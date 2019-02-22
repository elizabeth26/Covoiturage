<?php
class Connexion{
	private $per_login;
	private $per_pwd;
	private $captcha_reponse;
	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				 $this->affecte($valeurs);
	}
	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
								case 'per_login': $this->setNomUt($valeur); break;
								case 'per_pwd': $this->setMotPassCripte($valeur); break;
								case 'captcha_reponse': $this->setCapch_reponse($valeur); break;
						}
				}
		}

		public function getNomUt() {
		        return $this->per_login;
		    }
		public function setNomUt($per_login){
		        $this->per_login=$per_login;
		    }

		public function getMotPassCripte() {
		        return $this->per_pwd;
		    }

		public function setMotPassCripte($per_pwd){
					$this->per_pwd = createPasswordCrypte($per_pwd);
				}

		public function getCapch_reponse() {
						return $this->captcha_reponse;
				}
		public function setCapch_reponse($captcha_reponse){
						$this->captcha_reponse=$captcha_reponse;
				}
}
?>
