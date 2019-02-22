<h1>Liste de villes</h1>
<?php
  $pdo=new Mypdo();
  $VilleManager = new VilleManager($pdo);

  $listevilles=$VilleManager->getAllVille();
  $nbvilles=count($listevilles);
  echo "<p>Actuellement ".$nbvilles." villes sont enregistrées</p>";
 ?>
 <div id="idtable">
   <table >
     <tr>
       <th>Numéro</th>
       <th>Nom</th>
    </tr>

      <?php
      echo " <tr>";
      foreach ($listevilles as $ville):
        echo "<td>".$ville->getVilNum()." </td>";
        echo "<td>".$ville->getVilNom()." </td>";
        echo "</tr>";
      endforeach; ?>


   </table>
 </div>
