<?php
class AvisManager{
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function RecupereAvisNote($per_num){
		$sql = 'SELECT ROUND(AVG(avi_note), 1) as moyenne_avis FROM avis WHERE per_num = :per_num';

		$requete = $this->db->prepare($sql);
    $requete->bindValue(':per_num', $per_num);
		$requete->execute();

		$moyenne_avis = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();

		if($moyenne_avis->moyenne_avis != null){
			return $moyenne_avis->moyenne_avis;
		}
		else{
			return "Non noté";
		}
	}

	public function RecupereDernierAvis($per_num){
		$sql = 'SELECT avi_comm FROM avis
						WHERE per_num = :per_num
						ORDER by avi_date DESC
						LIMIT 1';
		$requete = $this->db->prepare($sql);
		$requete->bindValue(':per_num', $per_num);
		$requete->execute();

		$avis = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();

		if($avis != null){
			return $avis->avi_comm;
		}
		else{
			return "Non noté";
		}
	}
}
