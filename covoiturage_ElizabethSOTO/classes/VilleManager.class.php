	<?php
class VilleManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function addVille($ville){
			if($this->si_villeExiste($ville)){
				return false;
			}
			else{
				$requete = $this->db->prepare(
				'INSERT INTO ville(vil_nom) VALUES (:nom);');

				$requete->bindValue(':nom',$ville->getVilNom());
				$retour=$requete->execute();

				return $retour;
			}

		}

		public function si_villeExiste($ville){
				$sql = 'SELECT vil_nom FROM ville WHERE vil_nom = :ville';

				$requete = $this->db->prepare($sql);
				$requete->bindValue(':ville', $ville->getVilNom());

				$requete->execute();

				$resultat = $requete->fetch(PDO::FETCH_OBJ);
				$requete->closeCursor();

				return $resultat != null;
			}

		public function getAllVille(){
        $listeVilles = array();

        $sql = 'SELECT vil_num, vil_nom FROM ville';

        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($ville = $requete->fetch(PDO::FETCH_OBJ))
          $listeVilles[] = new Ville($ville);
          $requete->closeCursor();
          return $listeVilles;
		}

		public function RecupereVilleObj($numVille){
				$sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num = :num';

				$requete = $this->db->prepare($sql);
				$requete->bindValue(':num', $numVille);
				$requete->execute();

				$ville = $requete->fetch(PDO::FETCH_OBJ);
				$requete->closeCursor();

				$VilleObj = new Ville($ville);
				return $VilleObj;
			}


}
?>
