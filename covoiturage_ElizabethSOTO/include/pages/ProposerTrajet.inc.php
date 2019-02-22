<?php
if(isset($_SESSION['login_user'])){
  $pdo = new Mypdo();?>
  <h1>Proposer un trajet</h1>
  <?php

  if(empty($_POST['vil_dep'])){
    $parcoursManager = new ParcoursManager($pdo);
    $listeVillesParcours = $parcoursManager->getAllVilles();
    ?>
      <form method="post" action="#">
        <label>Ville de départ : </label>
          <select name="vil_dep" id="vil_dep">
            <?php foreach ($listeVillesParcours as $ville) {
              echo "<option value=".$ville->getVilNum().">".$ville->getVilNom()."</option>\n";
            }?>
          </select>
        </br>
        <div class="btn">
          <input type="submit" value="Valider" class="button">
        </div>
      </form>
    <?php
  }
  else{
    if(empty($_POST['vil_arrivee'])){
      $villeManager = new VilleManager($pdo);
      $villedep = $villeManager->RecupereVilleObj($_POST['vil_dep']);

      $parcoursManager = new ParcoursManager($pdo);
      $listeVillesArrivee = $parcoursManager->RecupereVillesArrivee($_POST['vil_dep']);
    ?>

    <form  class="cont_form" method="post" action="#">
      <div class="prop_cont">
        <div class="right_prop">
          <div class="cont_input">
            <label >Ville de départ :<?php echo $villedep->getVilNom();?> </label>
              <input  type="hidden" id="vil_dep" name="vil_dep" value=<?php echo $villedep->getVilNum();?>>
          </div>
          <div class="cont_input">
            <label >Date de départ : </label>
            <input type="date" id="pro_date" name="pro_date" pattern="[0-9]{2}-[0-9]{4}-[0-9]{2}" value='<?php echo date('Y-m-d');?>' min='<?php echo date('Y-m-d');?>'required/>
          </div>
          <div class="cont_input">
            <label >Nombre de places : </label>
            <input type="number" id="pro_place" name="pro_place" min="1" placeholder="Min: 1" required/>
          </div>
        </div>
        <div class="left_prop">
          <div class="cont_input">
            <label >Ville d'arrivée : </label>
              <select name="vil_arrivee" id="vil_arrivee">
                <?php foreach ($listeVillesArrivee as $villeArrivee) {
                  echo "<option value=".$villeArrivee->getVilNum().">".$villeArrivee->getVilNom()."</option>\n";
                }?>
              </select>
          </div>
          <div class="cont_input">
            <label >Heure de départ : </label>
            <input type="time" id="pro_time" name="pro_time" pattern="[0-9]{2}:[0-9]{2}" value='<?php echo date('H:i');?>'required/>
          </div>
        </div>
      </div>
      <div class="btn">
          <input type="submit" value="Valider" class="button">
      </div>

    </form>

    <?php
    }else{
      $propose = new Propose($_POST);
    	$parcoursManager = new ParcoursManager($pdo);
    	$infosParcours = $parcoursManager->RecupereInfoParcours($_POST['vil_dep'], $_POST['vil_arrivee']);
      $propose->setParnum($infosParcours->par_num);
      $propose->setProSens($infosParcours->pro_sens);

      $personneManager = new PersonneManager($pdo);
      $numPersonne = $personneManager->getNumPersonneavecLogin($_SESSION['login_user']);
      $propose->setPerNum($numPersonne);

      $proposeManager = new ProposeManager($pdo);

    	$retour = $proposeManager->addTrajetPropose($propose);

      if($retour){ ?>
        <p><img class='icone' src='image/valid.png'> Vôtre trajet a été ajouté avec succés</p>
        <?php header("Refresh: 2;URL=index.php");

      }else{ ?>
        <p><img class='icone' src='image/erreur.png'>Échec, Vôtre trajet n'a pas eté ajouté</p>

      <?php
      }
    }
  }
  ?>
<?php
}
else{ ?>
  <p>Vous devez être connecté pour Proposer un Trajet !</p>
  <?php header("Refresh: 2;URL=index.php");
}?>
