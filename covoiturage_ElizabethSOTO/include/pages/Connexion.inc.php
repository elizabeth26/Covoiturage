<?php
if (!isset($_SESSION['login_user'])){

  if(!empty($_POST)){
    $pdo = new Mypdo();
    $connexionManager = new ConnexionManager($pdo);
    $connexion=new Connexion($_POST);
    $infosCorrects = $connexionManager->verif_connexion_valide($connexion);
    $captchaValide = $connexionManager->captchaEstValide($_SESSION['nbAlea1'], $_SESSION['nbAlea2'], $_POST['captcha']);

    if($infosCorrects){
        if($captchaValide){
          $_SESSION['login_user'] = $_POST['per_login'];
          unset($_SESSION['nbAlea1']);
          unset($_SESSION['nbAlea2']);

          echo "<p><img class='icone' src='image/valid.png'>"." ".$_SESSION['login_user']." "."vous êtes connecté </p>";
          header("Refresh: 2;URL=index.php?page=9");
        }
        else{
          echo "<p><img class = 'icone' src='image/erreur.png'> Captcha invalide</p>";
          $_SESSION['AffFormulaire'] = true;
        }
    }
    else{
      echo "<p><img class = 'icone' src='image/erreur.png'> Vôtre Identifiant ou mot de passe sont invalides</p>";
      $_SESSION['AffFormulaire'] = true;
    }
  }
  else{
    $_SESSION['AffFormulaire'] = true;
  }

  if(isset($_SESSION['AffFormulaire'])){
    unset($_SESSION['AffFormulaire']);
    $_SESSION['nbAlea1'] = rand(1, 9);
    $_SESSION['nbAlea2'] = rand(1, 9); ?>

    <h1>Pour vous connecter</h1>

    <form  action="#" method="post">

      <label>Nom d'utilisateur : </label>
      <br>
        <input type="text" name="per_login" id="per_login" required/>
      <br>
      <label>Mot de passe : </label>
      <br>
        <input type="password" name="per_pwd" id="per_pwd" required/>

      <div class="captcha">
      <img src="image/nb/<?php echo $_SESSION['nbAlea1']?>.jpg"><label>+</label> <img src="image/nb/<?php echo $_SESSION['nbAlea2']?>.jpg"> <label>=</label>
      </div>
      <input type="text" name="captcha" id="captcha" required/>
      <div class="btn">
          <input type="submit" value="Valider" class="button">
      </div>
    </form>
  <?php } ?>

<?php
  }
  else{
    echo "<p>".$_SESSION['login_user']." Vous avez bien été déconnecté !</p>";
    session_destroy();
    header("Refresh: 2;URL=index.php");
  }
?>
