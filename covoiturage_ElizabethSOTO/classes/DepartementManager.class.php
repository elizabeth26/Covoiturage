<?php
class DepartementManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		 }

		public function add($departement){
				$requete = $this->db->prepare(
				'INSERT INTO departement(dep_nom,vil_num) VALUES (:dep_nom, :vil_num);');
				$requete->bindValue(':dep_nom',$departement->getDepNom());
				$requete->bindValue(':vil_num',$departement->getVilNum());
				$retour=$requete->execute();

				return $retour;
			}

		public function getAllDepartement(){
					$listeDepartement = array();
					$sql = 'SELECT dep_num, dep_nom, vil_num from departement';
					$requete = $this->db->prepare($sql);
					$requete->execute();

					while ($departement = $requete->fetch(PDO::FETCH_OBJ))
						$listeDepartement[] = new Departement($departement);
						$requete->closeCursor();
						return $listeDepartement;
			}

			public function recupererDepartementObj($dep_num){

				$sql = 'SELECT dep_num, dep_nom, vil_num FROM departement WHERE dep_num = :dep_num';

				$requete = $this->db->prepare($sql);
				$requete->bindValue(':dep_num', $dep_num);
				$requete->execute();

				$departement = $requete->fetch(PDO::FETCH_OBJ);

				$requete->closeCursor();

				$departementObj = new Departement($departement);
				return $departementObj;
			}

	}
