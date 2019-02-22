<?php
class ParcoursManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($parcours){
			if($this->siparcoursExiste($parcours) OR $this->parcoursPasValide($parcours)){
			return false;

			}
			else {
				$requete = $this->db->prepare(
				'INSERT INTO parcours(par_km,vil_num1,vil_num2) VALUES (:km, :vil1, :vil2);');

				$requete->bindValue(':km',$parcours->getNbKm());
				$requete->bindValue(':vil1',$parcours->getVille1());
				$requete->bindValue(':vil2',$parcours->getVille2());

				$retour=$requete->execute();
				return $retour;
			}

		}
		public function siparcoursExiste($parcours){
			$sql = 'SELECT par_num FROM parcours WHERE (vil_num1 = :ville1 AND vil_num2 = :ville2) OR (vil_num1 = :ville2 AND vil_num2 = :ville1)';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':ville1', $parcours->getVille1());
			$requete->bindValue(':ville2', $parcours->getVille2());

			$requete->execute();

			$resultat = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();

			return $resultat != null;
		}

		public function parcoursPasValide($parcours){
			return $parcours->getVille1() === $parcours->getVille2();
		}

		public function getAllParcours(){
			$listeParcours = array();
			$sql = 'SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours';
			$requete = $this->db->prepare($sql);
			$requete->execute();

			while ($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$listeParcours[] = new Parcours($parcours);
					$requete->closeCursor();
					return $listeParcours;
		}
		public function RecupereInfoParcours($numVilDep, $numVilArrive){
			$sql = 'SELECT par_num, 0 as pro_sens FROM parcours
							WHERE (vil_num1 = :numVilDep AND vil_num2 = :numVilArrive)
							UNION
							SELECT par_num, 1 as pro_sens FROM parcours
							WHERE (vil_num1 = :numVilArrive AND vil_num2 = :numVilDep)';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':numVilDep', $numVilDep);
			$requete->bindValue(':numVilArrive', $numVilArrive);

			$requete->execute();

			$infoParcours = $requete->fetch(PDO::FETCH_OBJ);

			$requete->closeCursor();
			return $infoParcours;
		}
		public function recuperenomVille($num_ville){
			$requete = $this->db->prepare(
			"SELECT vil_nom FROM ville where vil_num=".$num_ville);
			$requete->execute();
			$res = $requete->fetch(PDO::FETCH_OBJ);
			$ville = new Ville($res);
			$requete->closeCursor();
			return 	$ville->getVilNom();
		}
		public function getAllVilles(){
			$sql = 'SELECT T.vil_num, v.vil_nom FROM
								(
									SELECT vil_num1 as vil_num FROM parcours
									UNION
									SELECT vil_num2 FROM parcours
								)T
							INNER JOIN ville v ON (v.vil_num = T.vil_num)';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($ville = $requete->fetch(PDO::FETCH_OBJ)){
				$listeVilles[] = new Ville($ville);
			}

			$requete->closeCursor();
			return $listeVilles;
		}

		public function RecupereVillesArrivee($numDepVil){

			$sql = 'SELECT T.vil_num, v.vil_nom FROM
							(
								SELECT vil_num1 as vil_num FROM parcours
								WHERE vil_num2 = :numDepVil
								UNION
								SELECT vil_num2 FROM parcours
								WHERE vil_num1 = :numDepVil
							)T
							INNER JOIN ville v ON (v.vil_num = T.vil_num)';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':numDepVil', $numDepVil);

			$requete->execute();

			while($ville = $requete->fetch(PDO::FETCH_OBJ)){
				$listeVilles[] = new Ville($ville);
			}

			$requete->closeCursor();
			return $listeVilles;
		}
}
