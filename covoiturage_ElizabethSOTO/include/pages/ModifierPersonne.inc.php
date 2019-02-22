<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
if(!isset($_SESSION['obj_personne'])){
  if(empty($_GET['num_pers'])){
    $personnes = $personneManager->getAllPersonne();
    ?>
    <h1>Modifier une personne enregistrée</h1>
    <p>Actuellement <?php echo count($personnes);?> personnes enregistrées</p>
    <div id="idtable">
      <table>
        <tr>
          <th>Numéro</th>
          <th>Nom</th>
          <th>Prénom</th>
        <tr>
        <?php foreach($personnes as $personne) { ?>
          <tr>
            <td><?php echo $personne->getPerNum();?></td>
            <td><?php echo $personne->getPerNom();?></td>
            <td><?php echo $personne->getPerPrenom();?></td>
  					<td><a href="index.php?page=3&amp;num_pers=<?php echo $personne->getPerNum();?>"><img class='icone' src='image/modifier.png' ></td>
          </tr>
        <?php } ?>
      </table>
    </div>

  <?php
  }else{
    $_SESSION['obj_personne'] = $personneManager->getPersonneObj($_GET['num_pers']);?>
    <h1>Modifier <?php echo $_SESSION['obj_personne']->getPerNom()." ".$_SESSION['obj_personne']->getPerPrenom()?></h1>
    <form method="post" action="#">
      <div class="cont_input">
        <label >Nom : </label>
          <input type="text" id="per_nom" name="per_nom" value="<?php echo $_SESSION['obj_personne']->getPerNom()?>" required/>
      </div>
      <div class="cont_input">
        <label >Prénom : </label>
          <input type="text" id="per_prenom" name="per_prenom" value="<?php echo $_SESSION['obj_personne']->getPerPrenom()?>" required/>
      </div>
      <div class="cont_input">
        <label >Téléphone : </label>
          <input type="tel" id="per_tel" name="per_tel" value="<?php echo $_SESSION['obj_personne']->getPerTel()?>" pattern='\d{2}\d{2}\d{2}\d{2}\d{2}' title="0XXXXXXXXX" required/>
      </div>
      <div class="cont_input">
        <label >Mail : </label>
          <input type="email" id="per_mail" name="per_mail" value="<?php echo $_SESSION['obj_personne']->getPerMail()?>" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"  title="yourMail@domain.fr" required/>
      </div>
      <div class="cont_input">
        <label >Login : </label>
          <input type="text" id="per_login" name="per_login" value="<?php echo $_SESSION['obj_personne']->getPerLogin()?>" required/>
        </br>
      </div>
      <div class="btn">
          <input type="submit" name="valider" value="Valider" class="button">
      </div>

    </form>
  <?php
  }

}
else{
  if(!empty($_POST['valider'])){
    $personne_modifie = new Personne($_POST);
    $retour = $personneManager->Actualiser_Pers($_SESSION['obj_personne']->getPerNum(), $personne_modifie);

    if($retour){
      echo "<p><img class='icone' src='image/valid.png'> La personne '<strong>".$_SESSION['obj_personne']->getPerPrenom()." ".$_SESSION['obj_personne']->getPerNom()."</strong>' a été modifiée</p>";
    }else{
      echo "<p><img class='icone' src='image/erreur.png'>Échec, La personne '<strong>".$_SESSION['obj_personne']->getPerPrenom()." ".$_SESSION['obj_personne']->getPerNom()."</strong>' n'a pas été modfiée</p>";
    }
    unset($_SESSION['obj_personne']);

    header("Refresh: 2;URL=index.php?page=3");
  }
  else {
    echo "<p><img class='icone' src='image/valid.png'>La personne '<strong>".$_SESSION['obj_personne']->getPerPrenom()." ".$_SESSION['obj_personne']->getPerNom()."</strong> n'a pas été modifiée</p>";
    unset($_SESSION['obj_personne']);
    header("Refresh: 2;URL=index.php?page=3");
  }
}
  ?>
