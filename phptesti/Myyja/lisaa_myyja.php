<?php
    // Otetaan tiedosto mukaan joka pitää sisällään luokan, jonka avulla saamme yhteyden tietokantaan.
    require 'database.php';
 
    // Jos käyttäjä on painanut lomakkeen Lisää-painiketta, niin lomakkeen action aktivoituu ja 
    // lähettää lomakkeen sisältämät tiedot POST-metodilla tälle samalle sivulle.
    // Eli if lohkon sisälle mennään vastaa Lisää-painikkeen painamisen jällkeen ei ensimmäisellä kerralla sivulle tultaessa.
    if ( !empty($_POST)) {
        // Luodaat ja alustetaan muuttujat kenttien sisällön tarkistusta varten
        $etunimiError = null;
        $sukunimiError = null;
        $lahiosoiteError = null;
        $postinumeroError = null;
        $postitoimipaikkaError = null;
        $puhelinError = null;
        $sahkopostiError = null;
        $henkilotunnusError = null;
         
        // Luetaan muuttujiin POST-metodin lähettämät tiedot
        $etunimi = $_POST['etunimi'];
        $sukunimi = $_POST['sukunimi'];
        $lahiosoite = $_POST['lahiosoite'];
        $postinumero = $_POST['postinumero'];
        $postitoimipaikka = $_POST['postitoimipaikka'];
        $kayttajatunnus = $_POST['kayttajatunnus'];
        $salasana = $_POST['salasana'];
        $rooli = $_POST['rooli'];
     
        // Tarkistetaan käyttäjän syötteet (tarkistetaan vain että eivät ole tyhjiä). 
        // Jos kenttä on tyhjä, niin tallennetaan ohje teksti kentään viittaavaan Error muuttujaan
        $valid = true;
        if (empty($etunimi)) {
            $etunimiError = 'Syötä etunimi';
            $valid = false;
        }
        
        if (empty($sukunimi)) {
            $sukunimiError = 'Syötä sukunimi';
            $valid = false;
        }
        
        if (empty($lahiosoite)) {
            $lahiosoiteError = 'Syötä lahiosoite';
            $valid = false;
        }
        
        if (empty($postinumero)) {
            $postinumeroError = 'Syötä postinumero';
            $valid = false;
        }
        
        if (empty($postitoimipaikka)) {
            $postitoimipaikkaError = 'Syötä postitoimipaikka';
            $valid = false;
        }
        
        if (empty($kayttajatunnus)) {
            $kayttajatunnusError = 'Syötä käyttäjätunnus';
            $valid = false;
        }
        
        if (empty($salasana)) {
            $salasanaError = 'Syötä salasana';
            $valid = false;
        }
        
        if (empty($rooli)) {
            $rooliError = 'Syötä rooli';
            $valid = false;
        }
        
         
        // Kirjoitetaan tiedot tietokannan tauluun, jos kenttien syötteet olivat kunnossa
        // Ohjetaan käyttäjä myyja.php sivulle
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");   
            $sql = "INSERT INTO myyja (etunimi, sukunimi, rooli, kayttajatunnus, lahiosoite, postinumero, postitoimipaikka, salasana) values(?, ?, ?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($etunimi, $sukunimi, $rooli, $kayttajatunnus, $lahiosoite, $postinumero, $postitoimipaikka, $salasana));
            Database::disconnect();
            header("Location: myyja.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="fi">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
			integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Videovuokraamo</title>
  </head>
  <body>

    <div class="container">
        <div class="row">
            <h3>Lisää myyjä</h3>
        </div>
        <!--    Lomake myyjätietojen syöttämistä varten.
                Koodissa käytetään lyhennettyä if-else -lausetta (esim. !empty($henkilotunnusError)?'alert alert-info':'';)
                Koodissa käytetään myös if-lausetta joka päättyy kohdassa endif
        -->
        <form  action="lisaa_myyja.php" method="post">

          <div class="form-group row <?php echo !empty($rooliError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Rooli</label>
            <div class="col-sm-10">
                <input name="rooli" type="text"  placeholder="Rooli" value="<?php echo !empty($rooli)?$rooli:'';?>">
                <?php if (!empty($rooliError)): ?>
                    <small class="text-muted">
                        <?php echo $rooliError;?>
                    </small>          
                <?php endif; ?>        
            </div>
          </div>

          <div class="form-group row <?php echo !empty($etunimiError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Etunimi</label>
            <div class="col-sm-10">
                <input name="etunimi" type="text"  placeholder="Etunimi" value="<?php echo !empty($etunimi)?$etunimi:'';?>">
                <?php if (!empty($etunimiError)): ?>
                    <small class="text-muted">
                        <?php echo $etunimiError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($sukunimiError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Sukunimi</label>
            <div class="col-sm-10">
                <input name="sukunimi" type="text"  placeholder="Sukunimi" value="<?php echo !empty($sukunimi)?$sukunimi:'';?>">
                <?php if (!empty($sukunimiError)): ?>
                    <small class="text-muted">
                        <?php echo $sukunimiError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($lahiosoiteError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Lähiosoite</label>
            <div class="col-sm-10">
                <input name="lahiosoite" type="text"  placeholder="Lähiosoite" value="<?php echo !empty($lahiosoite)?$lahiosoite:'';?>">
                <?php if (!empty($lahiosoiteError)): ?>
                    <small class="text-muted">
                        <?php echo $lahiosoiteError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($postinumeroError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Postinumero</label>
            <div class="col-sm-10">
                <input name="postinumero" type="text"  placeholder="Postinumero" value="<?php echo !empty($postinumero)?$postinumero:'';?>">
                <?php if (!empty($postinumeroError)): ?>
                    <small class="text-muted">
                        <?php echo $postinumeroError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($postitoimipaikkaError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Postitoimipaikka</label>
            <div class="col-sm-10">
                <input name="postitoimipaikka" type="text"  placeholder="Postitoimipaikka" value="<?php echo !empty($postitoimipaikka)?$postitoimipaikka:'';?>">
                <?php if (!empty($postitoimipaikkaError)): ?>
                    <small class="text-muted">
                        <?php echo $postitoimipaikkaError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($kayttajatunnusError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Käyttäjätunnus</label>
            <div class="col-sm-10">
                <input name="kayttajatunnus" type="text"  placeholder="Käyttäjätunnus" value="<?php echo !empty($kayttajatunnus)?$kayttajatunnus:'';?>">
                <?php if (!empty($kayttajatunnusError)): ?>
                    <small class="text-muted">
                        <?php echo $kayttajatunnusError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($salasanaError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Salasana</label>
            <div class="col-sm-10">
                <input name="salasana" type="text"  placeholder="Salasana" value="<?php echo !empty($salasana)?$salasana:'';?>">
                <?php if (!empty($sahkopostiError)): ?>
                    <small class="text-muted">
                        <?php echo $salasanaError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-actions">
              <button type="submit" class="btn btn-success">Lisää</button>
              <a class="btn" href="myyja.php">Takaisin</a>
            </div>
        </form>
        
    </div> <!-- /container -->
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
			integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
			integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
			integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>