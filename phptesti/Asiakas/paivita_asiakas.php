<?php
    // Otetaan tiedosto mukaan joka pitää sisällään luokan, jonka avulla saamme yhteyden tietokantaan. 
    require 'database.php';
    $asiakasID = null; // Alustetaan muuttuja.

    // Tarkistetaan, että onko asiakasID parametri välitetty GET-metodilla
    // Jos on niin tallennetaan arvo muuttujaan
    if ( !empty($_GET['asiakasID'])) {
        $asiakasID = $_REQUEST['asiakasID'];
    }
    
    // Jos asiakasID parametriä ei välitetty, palautetaan käyttäjä takaisin asiakas.php sivulle
    if ( null==$asiakasID ) {
        header("Location: asiakas.php");
    }

    // Jos käyttäjä on painanut lomakkeen Päivitä-painiketta, niin lomakkeen action aktivoituu ja 
    // lähettää lomakkeen sisältämät tiedot POST-metodilla tälle samalle sivulle.
    // Eli if lohkon sisälle mennään vastaa Päivitä-painikkeen painamisen jällkeen ei ensimmäisellä kerralla sivulle tultaessa.
    // Else haarassa haetaan asiakasID parametrin mukaiset asiakastiedot tietokannasta
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
        $puhelin = $_POST['puhelin'];
        $sahkoposti = $_POST['sahkoposti'];
        $henkilotunnus = $_POST['henkilotunnus'];
     
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
            $lahiosoiteError = 'Syötä lähiosoite';
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
        
        if (empty($puhelin)) {
            $puhelinError = 'Syötä puhelin';
            $valid = false;
        }
        
        if (empty($sahkoposti)) {
            $sahkopostiError = 'Syötä sähköpostiosoite';
            $valid = false;
        }
        
        if (empty($henkilotunnus)) {
            $henkilotunnusError = 'Syötä henkilötunnus';
            $valid = false;
        }
        
         
        // Päivitetään tiedot tietokannan tauluun, jos kenttien syötteet olivat kunnossa
        // Ohjetaan käyttäjä asiakas.php sivulle
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");   
            $sql = "UPDATE asiakas SET etunimi = ?, sukunimi = ?, sahkoposti = ?, henkilotunnus = ?, lahiosoite = ?, postinumero = ?, postitoimipaikka = ?, puhelin = ? WHERE asiakasID = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($etunimi, $sukunimi, $sahkoposti, $henkilotunnus, $lahiosoite, $postinumero, $postitoimipaikka, $puhelin, $asiakasID));
            Database::disconnect();
            header("Location: asiakas.php");
        }
    }  else {
        // Haetaan asiakkaan tiedot tietokannasta ja luetaan ne muuttujiin, jotta olemassa olevat tiedot voidaan näyttää käyttäjälle
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");   
        $sql = "SELECT * FROM asiakas where asiakasID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($asiakasID));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $etunimi = $data['etunimi'];
        $sukunimi = $data['sukunimi'];
        $lahiosoite = $data['lahiosoite'];
        $postinumero = $data['postinumero'];
        $postitoimipaikka = $data['postitoimipaikka'];
        $puhelin = $data['puhelin'];
        $sahkoposti = $data['sahkoposti'];
        $henkilotunnus = $data['henkilotunnus'];
        Database::disconnect();
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
            <h3>Päivitä asiakas</h3>
        </div>
        
        <!--    Lomake asiakastietojen päivittämistä varten.
                Koodissa käytetään lyhennettyä if-else -lausetta (esim. !empty($henkilotunnusError)?'alert alert-info':'';)
                Koodissa käytetään myös if-lausetta joka päättyy kohdassa endif
                Huomioi, että formin action kentässä välitetään myös asiakasID parametri
        -->

        <form action="paivita_asiakas.php?asiakasID=<?php echo $asiakasID?>" method="post">

          <div class="form-group row <?php echo !empty($henkilotunnusError)?'':'';?>">
            <label class="col-sm-2 col-form-label text-right">Henkilötunnus</label>
            <div class="col-sm-10">
                <input name="henkilotunnus" type="text"  placeholder="Henkilötunnus" value="<?php echo !empty($henkilotunnus)?$henkilotunnus:'';?>">
                <?php if (!empty($henkilotunnusError)): ?>
                    <small class="text-muted">
                        <?php echo $henkilotunnusError;?>
                    </small>  
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($etunimiError)?'':'';?>">
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

          <div class="form-group row <?php echo !empty($sukunimiError)?'':'';?>">
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

          <div class="form-group row <?php echo !empty($lahiosoiteError)?'':'';?>">
            <label class="col-sm-2 col-form-label text-right">Lähiosoite</label>
            <div class="col-sm-10">
                <input name="lahiosoite" type="text"  placeholder="Lähiosoite" 
                       value="<?php echo !empty($lahiosoite)?$lahiosoite:'';?>">
                <?php if (!empty($lahiosoiteError)): ?>
                    <small class="text-muted">
                        <?php echo $lahiosoiteError;?>
                    </small>
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($postinumeroError)?'':'';?>">
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

          <div class="form-group row <?php echo !empty($postitoimipaikkaError)?'':'';?>">
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

          <div class="form-group row <?php echo !empty($puhelinError)?'':'';?>">
            <label class="col-sm-2 col-form-label text-right">Puhelin</label>
            <div class="col-sm-10">
                <input name="puhelin" type="text"  placeholder="Puhelin" value="<?php echo !empty($puhelin)?$puhelin:'';?>">
                <?php if (!empty($puhelinError)): ?>
                    <small class="text-muted">
                        <?php echo $puhelinError;?>
                    </small>
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($sahkopostiError)?'':'';?>">
            <label class="col-sm-2 col-form-label text-right">Sähkoposti</label>
            <div class="col-sm-10">
                <input name="sahkoposti" type="text"  placeholder="Sähkoposti" value="<?php echo !empty($sahkoposti)?$sahkoposti:'';?>">
                <?php if (!empty($sahkopostiError)): ?>
                    <small class="text-muted">
                        <?php echo $sahkopostiError;?>
                    </small>
                <?php endif; ?>
            </div>
          </div>

          <div class="form-actions">
              <button type="submit" class="btn btn-success">Päivitä</button>
              <a class="btn" href="asiakas.php">Takaisin</a>
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
