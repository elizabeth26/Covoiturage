                                                                                                                                                                                                                                                                                                     
<?php
class ProposeManager{
private $db;

  public function __construct($db){
    $this->db = $db;
  }

  public function addTrajetPropose($propose){
  		$sql = 'INSERT INTO propose(par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:numParcours, :numPersProp, :dateTrajet, :heureTrajet, :nbPlacesProp, :sensTrajetProp)';
  		$requete = $this->db->prepare($sql);

  		$requete->bindValue(':numParcours', $propose->getParnum());
  		$requete->bindValue(':numPersProp', $propose->getPerNum());
  		$requete->bindValue(':dateTrajet', $propose->getProDate());
  		$requete->bindValue(':heureTrajet', $propose->getProTime());
  		$requete->bindValue(':nbPlacesProp', $propose->getProPlace());
  		$requete->bindValue(':sensTrajetProp', $propose->getProSens());

  		$retour=$requete->execute();
  		$requete->closeCursor();

  		return $retour;
  	}

  	public function getAllVillesDep(){
  		$sql = 'SELECT T.vil_num, v.vil_nom FROM(
    							SELECT pa.vil_num1 as vil_num FROM parcours pa
    							INNER JOIN propose pr ON (pr.par_num = pa.par_num)
    							WHERE pr.pro_sens = 0
  							UNION
    							SELECT pa.vil_num2 FROM parcours pa
    							INNER JOIN propose pr ON (pr.par_num = pa.par_num)
    							WHERE pr.pro_sens = 1)T
    						  INNER JOIN ville v ON (v.vil_num = T.vil_num)';

  		$requete = $this->db->prepare($sql);
  		$requete->execute();

  		while($ville = $requete->fetch(PDO::FETCH_OBJ)){
  			$listeVilles[] = new Ville($ville);
  		}

  		$requete->closeCursor();
  		return $listeVilles;
  	}

    public function RecupererTrajetsCompatibles($num_parc, $date_dep, $heure_dep, $precision, $sens_parc){
      $sql = 'SELECT T.pro_date, T.pro_time, T.pro_place, T.per_num, p.per_nom, p.per_prenom FROM
              (
                SELECT pr.pro_date, pr.pro_time, pr.pro_place, pr.per_num FROM propose pr
                INNER JOIN parcours pa ON(pa.par_num = pr.par_num)
                WHERE pr.par_num = :num_parc
                AND pr.pro_sens = :sens_parc
                AND pro_date >= DATE_ADD(:date_dep, INTERVAL -(:precision) DAY)
                AND pro_date <= DATE_ADD(:date_dep, INTERVAL +(:precision) DAY)
                AND HOUR(pro_time) >= :heure_dep
              )T
              INNER JOIN personne p ON (p.per_num = T.per_num)
              ORDER BY T.pro_date, T.pro_time';

      $requete = $this->db->prepare($sql);
      $requete->bindValue(':num_parc', $num_parc);
      $requete->bindValue(':sens_parc', $sens_parc);
      $requete->bindValue(':date_dep', $date_dep);
      $requete->bindValue(':heure_dep', $heure_dep);
      $requete->bindValue(':precision', $precision);

      $requete->execute();

      while($trajet = $requete->fetch(PDO::FETCH_OBJ)){
        $listeTrajets[] = $trajet;
      }

      $requete->closeCursor();

      if(empty($listeTrajets)){
        return null;
      }

      return $listeTrajets;
    }

}
?>
