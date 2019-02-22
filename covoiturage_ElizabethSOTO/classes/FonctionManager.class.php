<?php
class FonctionManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

		public function addFonction($fonction){
				$requete = $this->db->prepare(
				'INSERT INTO fonction (fon_libelle) VALUES (:libelle);');
				//echo $ville->getVilNom();
				$requete->bindValue(':libelle',$fonction->getFonLib());
				$retour=$requete->execute();
				//var_dump($requete->debugDumpParams());
				return $retour;
			}

		public function getAllFonction(){
        $listeFonction = array();
        $sql = 'SELECT fon_num ,fon_libelle FROM fonction';

        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($fonction = $requete->fetch(PDO::FETCH_OBJ))
          $listeFonction[] = new Fonction($fonction);
          $requete->closeCursor();
          return $listeFonction;
		}
		public function RecupererFonctionObj($num_fonction){
			$sql = 'SELECT fon_num, fon_libelle FROM fonction WHERE fon_num = :fon_num';

			$requete = $this->db->prepare($sql);
			$requete->bindValue(':fon_num', $num_fonction);
			$requete->execute();

			$fonction = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();

			$fonctionObj = new Fonction($fonction);
			return $fonctionObj;
	}



}
?>
