	<?php
class ConnexionManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function verif_connexion_valide ($utilisateur){

		$requete = $this->db->prepare('SELECT  per_login, per_pwd FROM personne
		where per_login= :per_login AND per_pwd= :per_pwd');

		$requete->bindValue(':per_login',$utilisateur->getNomUt());
		$requete->bindValue(':per_pwd',$utilisateur->getMotPassCripte());
	  $requete->execute();

		$res = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();

		if($res!=null){
			  return $utilisateur->getMotPassCripte() === $res->per_pwd;
		}
		else{
				return false;
		}
	}

	public function captchaEstValide($aleat1, $aleat2, $reponse){
	return ($aleat1 + $aleat2) == $reponse;
}
}?>
