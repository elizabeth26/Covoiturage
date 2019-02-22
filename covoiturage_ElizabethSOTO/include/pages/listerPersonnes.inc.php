<?php
$pdo=new Mypdo();
$personneManager = new PersonneManager($pdo);
if(empty($_GET["id"])){
  echo "<h1>Liste des personnes enregistrées </h1>";
  $personnes=$personneManager->getAllPersonne();
 ?>
 <p>Actuellement <?php echo count($personnes);?> personnes enregistrées</p>
 <div id="idtable">
   <table >
     <tr>
       <th>Numéro</th>
       <th>Nom</th>
       <th>Prénom</th>
    </tr>
      <?php
      echo " <tr>";
      foreach ($personnes as $personne):

        echo "<td><a href=\"index.php?page=2&amp;id=".$personne->getPerNum()."\">".$personne->getPerNum()."</a></td>";
        echo "<td>".$personne->getPerNom()." </td>";
        echo "<td>".$personne->getPerPrenom()." </td>";
        echo "</tr>";
      endforeach;
    echo "</table>";
  echo "</div>";
}
else{
  $per_num = $_GET['id'];
  $personne = $personneManager->getPersonneObj($per_num);?>
  <?php
    if($personneManager->si_estEtudiant($per_num)){
      $etudiantManager = new EtudiantManager($pdo);
      $etudiant = $etudiantManager->RecupererEtudiantObj($personne, $per_num);

      $departementManager = new DepartementManager($pdo);
      $departement = $departementManager->recupererDepartementObj($etudiant->getDepNum());

      $villeManager = new VilleManager($pdo);
      $ville = $villeManager->RecupereVilleObj($departement->getVilNum()); ?>
      <h1>Détails sur l'étudiant <?php echo $etudiant->getPersObj()->getPerNom(); ?> </h1>

      <div id="idtable">
        <table>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Téléphone</th>
            <th>Département</th>
            <th>Ville</th>
          </tr>

          <tr>
            <td><?php echo $etudiant->getPersObj()->getPerNom();?></td>
            <td><?php echo $etudiant->getPersObj()->getPerPrenom();?></td>
            <td><?php echo $etudiant->getPersObj()->getPerMail();?></td>
            <td><?php echo $etudiant->getPersObj()->getPerTel();?></td>
            <td><?php echo $departement->getDepNom();?></td>
            <td><?php echo $ville->getVilNom();?></td>
          </tr>
        </table>

      </div>
  <?php
}else{
      $salarieManager = new SalarieManager($pdo);
      $salarie = $salarieManager->RecupererSalarieObj($personne, $per_num);

      $fonctionManager = new FonctionManager($pdo);
      $fonction = $fonctionManager->RecupererFonctionObj($salarie->getFonNum()); ?>
      <h1>Détails sur le salarié <?php echo $salarie->getPerObj()->getPerNom(); ?> </h1>
      <div id="idtable">
        <table>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Téléphone</th>
            <th>Téléphone pro</th>
            <th>Fonction</th>
          </tr>

          <tr>
            <td><?php echo $salarie->getPerObj()->getPerNom();?></td>
            <td><?php echo $salarie->getPerObj()->getPerPrenom();?></td>
            <td><?php echo $salarie->getPerObj()->getPerMail();?></td>
            <td><?php echo $salarie->getPerObj()->getPerTel();?></td>
            <td><?php echo $salarie->getTelprof();?></td>
            <td><?php echo $fonction->getFonLib();?></td>
          </tr>
        </table>

      </div>
    <?php
    }
}?>
