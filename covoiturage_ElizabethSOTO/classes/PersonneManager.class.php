<?php
class PersonneManager{
	private $db;

		public function __construct($db){
			$this->db = $db;

		}
		public function addPersonne($personne){
			if($this->sipersonneExiste($personne)){
				return false;
			}
			else {
				$requete = $this->db->prepare(

				'INSERT INTO personne(per_nom,per_prenom,per_tel,per_mail,per_login,per_pwd) VALUES (:per_nom,:per_prenom,:per_tel,:per_mail,:per_login,:per_pwd);');

				$requete->bindValue(':per_nom',$personne->getPerNom());
				$requete->bindValue(':per_prenom',$personne->getPerPrenom());
				$requete->bindValue(':per_tel',$personne->getPerTel());
				$requete->bindValue(':per_mail',$personne->getPerMail());
				$requete->bindValue(':per_login',$personne->getPerLogin());
				$requete->bindValue(':per_pwd',$personne->getPerPwd());

				$retour=$requete->execute();
				$requete->closeCursor();
				return $retour;
			}

		}

		public function getAllPersonne(){
      $listePersonnes = array();
      $sql = 'SELECT per_num, per_nom, per_prenom FROM personne ';
      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($personne = $requete->fetch(PDO::FETCH_OBJ))
          $listePersonnes[] = new Personne($personne);
	        $requete->closeCursor();
	        return $listePersonnes;
		}

		public function sipersonneExiste($personne){
			$sql = 'SELECT per_num FROM personne WHERE per_mail = :p_mail OR per_login = :p_login';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':p_mail', $personne->getPerMail());
			$requete->bindValue(':p_login', $personne->getPerLogin());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
			return $resultat != null;
		}

		public function getPersonneObj($per_num){
		$sql = 'SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login FROM personne WHERE per_num = :p_num';

		$requete = $this->db->prepare($sql);
		$requete->bindValue(':p_num', $per_num);
		$requete->execute();

		$personne = $requete->fetch(PDO::FETCH_OBJ);

		$requete->closeCursor();

		$PersonneObj = new Personne($personne);
		return $PersonneObj;
	}

	public function si_estEtudiant($per_num){
		$sql = 'SELECT per_num FROM etudiant WHERE per_num = :p_num';

		$requete = $this->db->prepare($sql);
		$requete->bindValue(':p_num', $per_num);

		$requete->execute();

		$resultat = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();

		return $resultat != null;
	}
	public function getNumPersonneavecLogin($per_login){
		$sql = 'SELECT per_num FROM personne WHERE per_login = :p_login';

		$requete = $this->db->prepare($sql);
		$requete->bindValue(':p_login', $per_login);
		$requete->execute();

		$resultat = $requete->fetch(PDO::FETCH_OBJ);

		$requete->closeCursor();

		return $resultat->per_num;
	}
	public function Actualiser_Pers($num_pers, $pers_modifie){
		$sql = 'UPDATE personne SET per_nom = :nom_nouv, per_prenom = :prenom_nouv, per_tel = :tel_nouv, per_mail = :mail_nouv, per_login = :login_nouv
						WHERE per_num = :num_pers';
		$requete = $this->db->prepare($sql);

		$requete->bindValue(':num_pers', $num_pers);
		$requete->bindValue(':nom_nouv', $pers_modifie->getPerNom());
		$requete->bindValue(':prenom_nouv', $pers_modifie->getPerPrenom());
		$requete->bindValue(':tel_nouv', $pers_modifie->getPerTel());
		$requete->bindValue(':mail_nouv', $pers_modifie->getPerMail());
		$requete->bindValue(':login_nouv', $pers_modifie->getPerLogin());

		$retour=$requete->execute();
		$requete->closeCursor();

		return $retour;
	}

		public function deletePersonne($per_num){

				$sql = 'DELETE FROM avis WHERE per_num = :per_num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num);
				$retour=$requete->execute();
				$requete->closeCursor();

				$sql = 'DELETE FROM salarie WHERE per_num = :per_num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num);
				$retour=$requete->execute();
				$requete->closeCursor();

				$sql = 'DELETE FROM etudiant WHERE per_num = :per_num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num);
				$retour=$requete->execute();
				$requete->closeCursor();

				$sql = 'DELETE FROM propose WHERE per_num = :per_num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num);
				$retour=$requete->execute();
				$requete->closeCursor();

				$sql = 'DELETE FROM personne WHERE per_num = :per_num';
				$requete = $this->db->prepare($sql);
				$requete->bindValue(':per_num', $per_num);
				$retour=$requete->execute();
				$requete->closeCursor();

				return $retour;
		}
}
