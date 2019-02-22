<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);

if(!isset($_SESSION['num_perso'])){
  if(empty($_GET['num_pers'])){
    $personnes = $personneManager->getAllPersonne();
    ?>
		<h1>Supprimer une personne enregistrée</h1>
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
  					<td><a href="index.php?page=4&amp;num_pers=<?php echo $personne->getPerNum();?>"><img class='icone' src='image/erreur.png' alt='Supprimer une personne'></td>
          </tr>
        <?php } ?>

      </table>
    </div>

  <?php
  }else{
      $_SESSION['num_perso'] = $_GET['num_pers'];
      $personne = $personneManager->getPersonneObj($_SESSION['num_perso']);
    ?>
    <form method="post" action="#">
      <label >Etes-vous sûr(e) de vouloir supprimer <?php echo $personne->getPerPrenom()." ".$personne->getPerNom() ?>? </label></br>
			<div class="btn">
			 <input type="submit" id="confirmer" name="confirmer" value="Confirmer" class="button"/>
			</div>
			<div class="btn">
			  <input type="submit" id="annuler" name="annuler" value="Annuler" class="button"/>
			</div>

    </form>

  <?php
  }

}else{
  if(!empty($_POST['confirmer'])){
    $personne = $personneManager->getPersonneObj($_SESSION['num_perso']);
    $retour = $personneManager->deletePersonne($_SESSION['num_perso']);

    if($retour){
      echo "<p><img class='icone' src='image/valid.png'><strong>".$personne->getPerPrenom()." ".$personne->getPerNom()."</strong>' a été supprimée</p>";
      header("Refresh: 2;URL=index.php?page=4");
    }else{
      echo "<p><img class='icone' src='image/erreur.png'>Échec, La personne <strong>".$personne->getPerPrenom()." ".$personne->getPerNom()."</strong>' n'a pas été supprimée</p>";
      header("Refresh: 2;URL=index.php?page=4");
    }
  }else{
    unset($_SESSION['num_perso']);
    header("Refresh:2 ;URL=index.php?page=4");
  }
}
  ?>
