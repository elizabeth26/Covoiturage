<?php
if(isset($_SESSION['login_user'])){
  $pdo = new Mypdo();?>
  <h1>Rechercher un trajet</h1>
      <?php
    if(empty($_POST['vil_dep'])){
      $proposeManager = new ProposeManager($pdo);
      $listeVilles = $proposeManager->getAllVillesDep();
      ?>
      <form method="post" action="#">
        <label>Ville de départ : </label>
          <select name="vil_dep" id="vil_dep">
            <?php foreach ($listeVilles as $ville) {
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
    else
    {
      if(empty($_POST['vil_arrivee'])){
          $villeManager = new VilleManager($pdo);
          $ville = $villeManager->RecupereVilleObj($_POST['vil_dep']);

          $parcoursManager = new ParcoursManager($pdo);
          $listeVillesArrivee = $parcoursManager->RecupereVillesArrivee($_POST['vil_dep']);
        ?>

        <form class="cont_form" method="post" action="#">
          <div class="traj_cont">
            <div class="right_traj">
              <div class="cont_input">
                <label >Ville de départ :<?php echo $ville->getVilNom();?> </label>
                <input type="hidden" id="vil_dep" name="vil_dep" value='<?php echo $ville->getVilNum();?>'/>
              </div>
              <div class="cont_input">
                <label >Date de départ : </label>
                  <input type="date" id="pro_date" name="pro_date" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value='<?php echo date('Y-m-d');?>' min='<?php echo date('Y-m-d');?>'required/>
              </div>
              <div class="cont_input">
                <label >À partir de : </label>
                  <select name="pro_time" id="pro_time">
                    <?php for ($i = 0; $i < 24; $i++) {
                      echo "<option value=".$i.">".$i."h</option>\n";
                    }?>
                  </select>
              </div>
            </div>
            <div class="left_traj">
              <div class="cont_input">
                <label >Ville d'arrivée : </label>
                  <select name="vil_arrivee" id="vil_arrivee">
                    <?php foreach ($listeVillesArrivee as $villeArrivee) {
                      echo "<option value=".$villeArrivee->getVilNum().">".$villeArrivee->getVilNom()."</option>\n";
                    }?>
                  </select>
              </div>
              <div class="cont_input">
                <label >Précision : </label>
                  <select name="precision" id="precision">
                    <option value="0">Ce jour</options>
                    <?php for ($i = 1; $i < 4; $i++) {
                      echo "<option value=".$i.">+/-".$i." jour(s)</option>\n";
                    }?>
                  </select>
              </div>
              <div class="btn">
                  <input type="submit" value="Valider" class="button">
              </div>
            </div>
          </div>
        </form>
        <?php
      }
      else
      {
        $parcoursManager = new ParcoursManager($pdo);
        $numParcours = $parcoursManager->RecupereInfoParcours($_POST['vil_dep'], $_POST['vil_arrivee']);

        $sensParcours = $numParcours->pro_sens;
        $numParcours = $numParcours->par_num;

        $proposeManager = new ProposeManager($pdo);
        $listeTrajets = $proposeManager->RecupererTrajetsCompatibles($numParcours, $_POST['pro_date'], $_POST['pro_time'], $_POST['precision'], $sensParcours);

        $villeManager = new VilleManager($pdo);
        $villeDepart = $villeManager->RecupereVilleObj($_POST['vil_dep']);
        $villeArrivee = $villeManager->RecupereVilleObj($_POST['vil_arrivee']);

        $avisManager = new AvisManager($pdo);

        if($listeTrajets != null){?>
        <div class="liste">
          <table>
            <tr>
              <th>Ville départ</th>
              <th>Ville arrivée</th>
              <th>Date départ</th>
              <th>Heure départ</th>
              <th>Nombre de place(s)</th>
              <th>Nom du covoitureur</th>
            <tr>
            <?php foreach($listeTrajets as $trajet) {
              $moyennePersonne = $avisManager->RecupereAvisNote($trajet->per_num);
              $dernierAvis = $avisManager->RecupereDernierAvis($trajet->per_num);?>
              <tr>
                <td><?php echo $villeDepart->getVilNom();?></td>
                <td><?php echo $villeArrivee->getVilNom();?></td>
                <td><?php echo getFrenchDate($trajet->pro_date);?></td>
                <td><?php echo $trajet->pro_time;?></td>
                <td><?php echo $trajet->pro_place;?></td>
                <td>
                  <a class="pop_up_avis" href="">
                     <?php echo $trajet->per_prenom." ".$trajet->per_nom;?>
                     <div>
                       <p>Moyenne des avis : <?php echo $moyennePersonne;?></p>
                       <p>Dernier avis : <?php echo $dernierAvis;?></p>
                     </div>
                  </a>
                </td>
              </tr>
            <?php } ?>

          </table>
        </div>

      <?php
        }
        else
        { ?>
          <p><img class = 'icone' src='image/erreur.png'> Désolé, Il y a pas de trajets disponibles !</p>
      <?php
        }
      }
    } ?>
    <?php
  }
else
  { ?>
    <p><img class = 'icone' src='image/erreur.png'> Vous devez être connecté pour Rechercher un Trajet !</p>
    <?php header("Refresh: 2;URL=index.php");
  }?>
