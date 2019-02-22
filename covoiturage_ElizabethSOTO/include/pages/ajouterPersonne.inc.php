<?php
if(!isset($_SESSION['ajouterPersonne'])){
  if(empty($_POST['per_nom'])){
   ?>
   <h1>Ajouter une personne</h1>
   <form class="cont_form" action="#" id="Ajouter_personne" method="post">
      <div class="cont_right_left">
        <div class="right">
          <div class="cont_input_per">
            <label >Nom : </label>
            <input type="text" name="per_nom" id="per_nom" size="15" required>
          </div>
          <div class="cont_input_per">
            <label >Téléphone : </label>
            <input type="text" name="per_tel" id="per_tel" size="15" pattern='\d{2}\d{2}\d{2}\d{2}\d{2}' title="0XXXXXXXXX" required>
          </div>
          <div class="cont_input_per">
            <label >Login : </label>
            <input type="text" name="per_login" id="per_login" size="15"  required>
          </div>
        </div>
        <div class="left">
           <div class="cont_input_per">
             <label >Prénom : </label>
             <input type="text" name="per_prenom" id="per_prenom" size="15" required>
           </div>
           <div class="cont_input_per">
             <label >Mail : </label>
             <input type="text" name="per_mail" id="per_mail" size="15" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"  title="yourMail@domain.fr" required>
           </div>
          <div class="cont_input_per">
            <label >Mot de passe : </label>
            <input type="password" name="per_pwd" id="per_pwd" size="15" required>
          </div>
        </div>
      </div>
       <div class="check">
          <label >Catégorie</label>
          <input type="radio" name="cat_pers"  value="etudiant" id="etudiant" checked>Etudiant
          <input type="radio" name="cat_pers" value="personnel" id="personnel"> Personnel
       </div>
      <div class="btn">
         <input type="submit" value="Valider"  class="button">
      </div>
   </form>
  <?php
  }
  else{
    $_SESSION['ajouterPersonne'] = new Personne($_POST);
      $pdo = new Mypdo();
      /*$PersonneManager = new PersonneManager($pdo);
      $retour=$PersonneManager->addPersonne($_SESSION['ajouterPersonne']);*/
          if($_POST['cat_pers'] == 'etudiant'){
            $divisionManager = new DivisionManager($pdo);
            $listeDivisions = $divisionManager->getAllDivision();

            $departementManager = new DepartementManager($pdo);
            $listeDepartements = $departementManager->getAllDepartement();

            $villeManager = new VilleManager($pdo);?>

            <h1>Ajouter un étudiant</h1>

            <form class="cont_form"  method="post" action="#">
              <div class="cont">
                <label >Année : </label>
                  <select name="div_num" id="div_num">
                    <?php foreach ($listeDivisions as $division) {
                      echo "<option value=".$division->getDivNum().">".$division->getDivNom()."</option>\n";
                    }?>
                  </select>
                </br>

                <label >Département : </label>
                  <select name="dep_num" id="dep_num">
                    <?php foreach ($listeDepartements as $departement) {
                      $ville = $villeManager->RecupereVilleObj($departement->getVilNum());
                      echo "<option value=".$departement->getDepNum().">".$departement->getDepNom()." - ".$ville->getVilNom()."</option>\n";
                    }?>
                  </select>
              </div>
            <div class="btn">
                <input type="submit" value="Valider" class="button">
            </div>
            </form>
        <?php
          }
          elseif($_POST['cat_pers'] == 'personnel'){
            $fonctionManager = new FonctionManager($pdo);
            $listeFonctions = $fonctionManager->getAllFonction(); ?>

            <h1>Ajouter un salarié</h1>

            <form class="cont_form" method="post" action="#">
              <div class="cont">
                <label >Téléphone professionnel : </label>
                  <input type="tel" id="sal_telprof" name="sal_telprof" pattern='\d{2}\d{2}\d{2}\d{2}\d{2}' title="0XXXXXXXXX" required/>
                </br>

                <label >Fonction : </label>
                  <select name="fon_num" id="fon_num">
                    <?php foreach ($listeFonctions as $fonction) {
                      echo "<option value=".$fonction->getFonNum().">".$fonction->getFonLib()."</option>\n";
                    }?>
                  </select>
                </br>
              </div>
              <div class="btn">
                    <input type="submit" value="Valider" class="button">
              </div>
            </form>
          <?php
          }
        }
      }

  else {
  $pdo = new Mypdo();
  $personne = new Personne($_SESSION['ajouterPersonne']);
  $PersonneManager = new PersonneManager($pdo);

  if(!empty($_POST['div_num'])){

    $etudiantManager = new EtudiantManager($pdo);
    $etudiant = new Etudiant($_SESSION['ajouterPersonne'], $_POST);

    $retour = $etudiantManager->addEtudiant($etudiant);

      if($retour){
        echo "<p><img class='icone' src='image/valid.png' > La personne  '<strong>".$etudiant->getPersObj()->getPerPrenom()." ".$etudiant->getPersObj()->getPerNom()."</strong>' a été ajouté</p>";
        header("Refresh: 2;URL=index.php?page=2");
      }
      else{
        echo "<p><img class='icone' src='image/erreur.png' > La personne  '<strong>".$etudiant->getPersObj()->getPerPrenom()." ".$etudiant->getPersObj()->getPerNom()."</strong>' existe déjà</p>";
        header("Refresh: 2;URL=index.php?page=2");
      }
  }
  elseif(!empty($_POST['sal_telprof'])){

    $salarieManager = new SalarieManager($pdo);
    $salarie = new Salarie($_SESSION['ajouterPersonne'], $_POST);

    $retour = $salarieManager->addSalarie($salarie);

      if($retour){
        echo "<p><img class='icone' src='image/valid.png' > La personne  '<strong>".$salarie->getPerObj()->getPerPrenom()." ".$salarie->getPerObj()->getPerNom()."</strong>' a été ajouté</p>";
        header("Refresh: 2;URL=index.php?page=2");
      }
      else{
        echo "<p><img class='icone' src='image/erreur.png' > La personne '<strong>".$salarie->getPerObj()->getPerPrenom()." ".$salarie->getPerObj()->getPerNom()."</strong>' existe déjà</p>";
        header("Refresh: 2;URL=index.php?page=2");
    }
  }
  unset($_SESSION['ajouterPersonne']);
  }
?>
