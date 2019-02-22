<?php
class Avis{
	private $per_num_cible;
	private $per_num_auteur;
  private $par_num;
  private $avi_comm;
  private $avi_note;
  private $avi_date;

	public function __construct($valeurs){
		if(!empty($valeurs)){
			$this->affecte($valeurs);
		}
	}

	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
								case 'per_num': $this->setNumPersonneCible($valeur); break;
								case 'per_per_num': $this->setNumPersonneAuteur($valeur); break;
								case 'par_num': $this->setNumParcours($valeur); break;
								case 'avi_comm': $this->setAvisCommentaire($valeur); break;
								case 'avi_note': $this->setAvisNote($valeur); break;
								case 'avi_date': $this->setDateAvis($valeur); break;

						}
				}
		}

	public function getNumPersonneCible(){
		return $this->per_num_cible;
	}

	public function setNumPersonneCible($per_num_cible){
		if(is_numeric($per_num_cible)){
			$this->per_num_cible = $per_num_cible;
		}
	}

	public function getNumPersonneAuteur(){
		return $this->per_num_auteur;
	}

	public function setNumPersonneAuteur($per_num_auteur){
    if(is_numeric($per_num_auteur)){
			$this->per_num_auteur = $per_num_auteur;
		}
	}

  public function getNumParcours(){
		return $this->par_num;
	}

	public function setNumParcours($par_num){
    if(is_numeric($par_num)){
			$this->par_num = $par_num;
		}
	}

  public function getAvisCommentaire(){
		return $this->avi_comm;
	}

	public function setAvisCommentaire($avi_comm){
		$this->avi_comm = $avi_comm;
	}

  public function getAvisNote(){
		return $this->avi_note;
	}

	public function setAvisNote($note){
    if(is_numeric($note) && ($note >= 0 && $note <=5)){
		    $this->avi_note = $note;
    }
	}

  public function getDateAvis(){
		return $this->avi_date;
	}

	public function setDateAvis($avi_date){
		$this->avi_date = $avi_date;
	}
}
