<?php
class EtudiantManager{
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function addEtudiant($etudiant){
		if(!$this->addEtudiantePers($etudiant->getPersObj())){
					return false;
		}
		else {
			$requete = $this->db->prepare(
			'INSERT INTO etudiant(per_num,dep_num,div_num) VALUES (:per_num, :dep_num, :div_num)');
			$requete->bindValue(':per_num', $this->db->lastInsertId());
			$requete->bindValue(':dep_num',$etudiant->getDepNum());
			$requete->bindValue(':div_num',$etudiant->getDivNum());
			$retour=$requete->execute();
			return $retour;
		}
	}

	public function addEtudiantePers($personne){
		$personneManager = new PersonneManager($this->db);
		$retour = $personneManager->addPersonne($personne);
		return $retour;
	}
	public function RecupererEtudiantObj($personneObj, $etu_num){

		$sql = 'SELECT dep_num, div_num FROM etudiant WHERE per_num = :per_num';
		$requete = $this->db->prepare($sql);
		$requete->bindValue(':per_num', $etu_num);
		$requete->execute();

		$etudiant = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();

		$EtudiantObj = new Etudiant($personneObj, $etudiant);
		return $EtudiantObj;
	}
}
