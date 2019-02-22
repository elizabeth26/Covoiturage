<h1>Liste de parcours proposés</h1>
<?php
  $pdo=new Mypdo();
  $ParcoursManager = new ParcoursManager($pdo);

  $listeparcours=$ParcoursManager->getAllParcours();
  $nbparcours=count($listeparcours)+1;
  echo "<p>Actuellement ".$nbparcours." parcours sont enregistrées</p>";
 ?>
 <div id="idtable">
   <table >
     <tr>
       <th>Numéro</th>
       <th>Nom Ville</th>
       <th>Nom Ville</th>
       <th>Nombre de km</th>

    </tr>

      <?php
      echo " <tr>";
      foreach ($listeparcours as $parcours):
        echo "<td>".$parcours->getParnum()." </td>";
        echo "<td>".$ParcoursManager->recuperenomVille($parcours->getVille1())." </td>";
        echo "<td>".$ParcoursManager->recuperenomVille($parcours->getVille2())." </td>";
        echo "<td>".$parcours->getNbKm()." </td>";
        echo "</tr>";
      endforeach; ?>


   </table>
 </div>
