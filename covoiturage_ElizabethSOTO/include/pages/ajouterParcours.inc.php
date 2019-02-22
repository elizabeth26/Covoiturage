<?php
if(empty($_POST['vil_num1']) && empty($_POST['vil_num2'])&&empty($_POST['par_km'])){
 ?>
 <h1>Ajouter un Parcours</h1>
 <?php
 $pdo=new Mypdo();
 $VilleManager = new VilleManager($pdo);

 $listevilles=$VilleManager->getAllVille();

 ?>
 <form class="cont_form" action="#" id="Ajouter_parcours" method="post">
   <div class="cont">
     <label>Ville 1: </label>
     <select name="vil_num1" id="vil_num1">
       <?php
        foreach ($listevilles as $ville):
          echo "<option value=".$ville->getVilNum().">".$ville->getVilNom() ."</option>";
        endforeach; ?>
     </select>

     <label>Ville 2: </label>
     <select name="vil_num2" id="vil_num2">
       <?php
        foreach ($listevilles as $ville):
          echo "<option value=".$ville->getVilNum().">".$ville->getVilNom() ."</option>";
        endforeach; ?>
     </select>
      <label> Nombre de kilomètres: </label>
      <input type="text" name="par_km" id="par_km" size="15" required>
   </div>
   <div class="btn">
     <input class="button" type="submit" value="Valider" />
   </div>
 </form>
<?php

}
else{
  $pdo=new Mypdo();
  $ParcoursManager = new ParcoursManager($pdo);
  $parcours = new Parcours($_POST);
  $retour=$ParcoursManager->add($parcours);
  if ($retour)
  {
   echo "<p><img class = 'icone' src='image/valid.png'> Le parcours a été ajoutée</p>";
   header("Refresh: 2;URL=index.php?page=6");
  }
  else
  {
  echo "<p><img class = 'icone' src='image/erreur.png'> Échec, Le parcours n'a pas été ajoutée</p>";
  header("Refresh: 2;URL=index.php?page=6");
  }
}
 ?>
