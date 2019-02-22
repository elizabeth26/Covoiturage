<?php
class SalarieManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function addSalarie($salarie){
			if(!$this->addSalariePers($salarie->getPerObj())){
						return false;
			}
			else{
				$requete = $this->db->prepare(
				'INSERT INTO salarie(per_num, sal_telprof,fon_num) VALUES (:per_num, :telsal, :numfon);');
				$requete->bindValue(':per_num',$this->db->lastInsertId());
				$requete->bindValue(':telsal',$salarie->getTelprof());
				$requete->bindValue(':numfon',$salarie->getFonNum());

				$retour=$requete->execute();
				return $retour;
			}
		}
		public function addSalariePers($personne){
				$personneManager = new PersonneManager($this->db);
				$retour = $personneManager->addPersonne($personne);
				return $retour;
			}
		public function RecupererSalarieObj($personneObj, $sal_num){

			$sql = 'SELECT sal_telprof, fon_num FROM salarie WHERE per_num = :per_num';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':per_num', $sal_num);
			$requete->execute();

			$salarie = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();

			$SalarieObj = new Salarie($personneObj, $salarie);
			return $SalarieObj;
		}

}
