<?php
	class DivisionManager{
		private $db;

			public function __construct($db){
				$this->db = $db;
			}

			public function add($division){
					$requete = $this->db->prepare(
					'INSERT INTO division(div_nom) VALUES (:divnom);');
					$requete->bindValue(':divnom',$division->getDivNom());
					$retour=$requete->execute();
					return $retour;
			}

			public function getAllDivision(){
					$listeDivision = array();
					$sql = 'SELECT div_num, div_nom from division';
					$requete = $this->db->prepare($sql);
					$requete->execute();

					while ($division = $requete->fetch(PDO::FETCH_OBJ))
						$listeDivision[] = new Division($division);
						$requete->closeCursor();
						return $listeDivision;
				}
		}
