<?php
if(empty($_POST['vil_nom'])){
 ?>
 <h1>Ajouter une ville</h1>
 <form action="#" id="Ajouter_ville" method="post">
<label > Nom: </label>
 <input type="text" name="vil_nom" id="vil_nom" size="15" required>

 <input class="button" type="submit" value="Valider" />
 </form>

<?php

}else{
  $pdo=new Mypdo();
  $VilleManager = new VilleManager($pdo);
  $ville = new Ville($_POST);
  $retour=$VilleManager->addVille($ville);
  $nomville=$ville->getVilNom();
  if ($retour) //retour contient le nombre de lignes affectées
  {
echo "<p><img class='icone' src='image/valid.png'>La ville <strong>"." \"".$nomville."\" "."</strong> a été ajoutée</p>";
   header("Refresh: 2;URL=index.php?page=7");
  }
  else
  {
   echo "<p><img class='icone' src='image/erreur.png'>La ville <strong>"." \"".$nomville."\" "."</strong> n'a pas été ajoutée</p>";
   header("Refresh: 2;URL=index.php?page=7");
  }
}
 ?>
