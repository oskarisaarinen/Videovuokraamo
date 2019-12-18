<?php
    // Otetaan tiedosto mukaan joka pitää sisällään luokan, jonka avulla saamme yhteyden tietokantaan.
    require 'database.php';
 
    // Jos käyttäjä on painanut lomakkeen Lisää-painiketta, niin lomakkeen action aktivoituu ja 
    // lähettää lomakkeen sisältämät tiedot POST-metodilla tälle samalle sivulle.
    // Eli if lohkon sisälle mennään vastaa Lisää-painikkeen painamisen jällkeen ei ensimmäisellä kerralla sivulle tultaessa.
    if ( !empty($_POST)) {
        // Luodaat ja alustetaan muuttujat kenttien sisällön tarkistusta varten
        $nimiError = null;
        $genreError = null;
        $kuvausError = null;
        $ikarajaError = null;
        $kestoError = null;
        $julkaisupaivaError = null;
        $tuotantovuosiError = null;
        $ohjaajaError = null;
        $nayttelijatError = null;
        $kuvaError = null;
         
        // Luetaan muuttujiin POST-metodin lähettämät tiedot
        $nimi = $_POST['nimi'];
        $genre = $_POST['genre'];
        $kuvaus = $_POST['kuvaus'];
        $ikaraja = $_POST['ikaraja'];
        $kesto = $_POST['kesto'];
        $julkaisupaiva = $_POST['julkaisupaiva'];
        $tuotantovuosi = $_POST['tuotantovuosi'];
        $ohjaaja = $_POST['ohjaaja'];
        $nayttelijat = $_POST['nayttelijat'];
        $kuva = $_POST['kuva'];
     
        // Tarkistetaan käyttäjän syötteet (tarkistetaan vain että eivät ole tyhjiä). 
        // Jos kenttä on tyhjä, niin tallennetaan ohje teksti kentään viittaavaan Error muuttujaan
        $valid = true;
        $valid = true;
        if (empty($nimi)) {
            $nimiError = 'Syötä nimi';
            $valid = false;
        }
        
        if (empty($genre)) {
            $genreError = 'Syötä genre';
            $valid = false;
        }
        
        if (empty($kuvaus)) {
            $kuvausError = 'Syötä kuvaus';
            $valid = false;
        }
        
        if (empty($ikaraja)) {
            $ikarajaError = 'Syötä ikäraja';
            $valid = false;
        }
        
        if (empty($kesto)) {
            $kestoError = 'Syötä kesto';
            $valid = false;
        }
        
        if (empty($julkaisupaiva)) {
            $julkaisupaivaError = 'Syötä julkaisupäivä';
            $valid = false;
        }
        
        if (empty($tuotantovuosi)) {
            $tuotantovuosiError = 'Syötä tuotantovuosi';
            $valid = false;
        }
        
        if (empty($ohjaaja)) {
            $ohjaajaError = 'Syötä ohjaaja';
            $valid = false;
        }

        if (empty($nayttelijat)) {
            $nayttelijatError = 'Syötä näyttelijä';
            $valid = false;
        }

        if (empty($kuva)) {
            $kuvaError = 'Syötä kuva';
            $valid = false;
        }
        
         
        // Kirjoitetaan tiedot tietokannan tauluun, jos kenttien syötteet olivat kunnossa
        // Ohjetaan käyttäjä video.php sivulle
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");   
            $sql = "INSERT INTO video (nimi, genre, kuvaus, ikaraja, kesto, julkaisupaiva, tuotantovuosi, ohjaaja, nayttelijat, kuva) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nimi, $genre, $kuvaus, $ikaraja, $kesto, $julkaisupaiva, $tuotantovuosi, $ohjaaja, $nayttelijat, $kuva));
            Database::disconnect();
            header("Location: video.php");
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
            <h3>Lisää video</h3>
        </div>
        <!--    Lomake myyjätietojen syöttämistä varten.
                Koodissa käytetään lyhennettyä if-else -lausetta (esim. !empty($henkilotunnusError)?'alert alert-info':'';)
                Koodissa käytetään myös if-lausetta joka päättyy kohdassa endif
        -->
        <form  action="lisaa_video.php" method="post">

          <div class="form-group row <?php echo !empty($nimiError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Nimi</label>
            <div class="col-sm-10">
                <input name="nimi" type="text"  placeholder="Nimi" value="<?php echo !empty($nimi)?$nimi:'';?>">
                <?php if (!empty($nimiError)): ?>
                    <small class="text-muted">
                        <?php echo $nimiError;?>
                    </small>          
                <?php endif; ?>        
            </div>
          </div>

          <div class="form-group row <?php echo !empty($genreError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Genre</label>
            <div class="col-sm-10">
                <input name="genre" type="text"  placeholder="Genre" value="<?php echo !empty($genre)?$genre:'';?>">
                <?php if (!empty($genreError)): ?>
                    <small class="text-muted">
                        <?php echo $genreError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($kuvausError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Kuvaus</label>
            <div class="col-sm-10">
                <input name="kuvaus" type="text"  placeholder="Kuvaus" value="<?php echo !empty($kuvaus)?$kuvaus:'';?>">
                <?php if (!empty($kuvausError)): ?>
                    <small class="text-muted">
                        <?php echo $kuvausError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($ikarajaError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Ikäraja</label>
            <div class="col-sm-10">
                <input name="ikaraja" type="text"  placeholder="Ikäraja" value="<?php echo !empty($ikaraja)?$ikaraja:'';?>">
                <?php if (!empty($ikarajaError)): ?>
                    <small class="text-muted">
                        <?php echo $ikarajaError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($kestoError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Kesto</label>
            <div class="col-sm-10">
                <input name="kesto" type="text"  placeholder="kesto" value="<?php echo !empty($kesto)?$kesto:'';?>">
                <?php if (!empty($kestoError)): ?>
                    <small class="text-muted">
                        <?php echo $kestoError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($julkaisupaivaError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Julkaisupäivä</label>
            <div class="col-sm-10">
                <input name="julkaisupaiva" type="text"  placeholder="Julkaisupäivä" value="<?php echo !empty($julkaisupaiva)?$julkaisupaiva:'';?>">
                <?php if (!empty($julkaisupaivaError)): ?>
                    <small class="text-muted">
                        <?php echo $julkaisupaivaError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($tuotantovuosiError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Tuotantovuosi</label>
            <div class="col-sm-10">
                <input name="tuotantovuosi" type="text"  placeholder="Tuotantovuosi" value="<?php echo !empty($tuotantovuosi)?$tuotantovuosi:'';?>">
                <?php if (!empty($tuotantovuosiError)): ?>
                    <small class="text-muted">
                        <?php echo $tuotantovuosiError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($ohjaajaError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Ohjaaja</label>
            <div class="col-sm-10">
                <input name="ohjaaja" type="text"  placeholder="Ohjaaja" value="<?php echo !empty($ohjaaja)?$ohjaaja:'';?>">
                <?php if (!empty($ohjaajaError)): ?>
                    <small class="text-muted">
                        <?php echo $ohjaajaError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($nayttelijatError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Näyttelijät</label>
            <div class="col-sm-10">
                <input name="nayttelijat" type="text"  placeholder="Näyttelijät" value="<?php echo !empty($nayttelijat)?$nayttelijat:'';?>">
                <?php if (!empty($nayttelijatError)): ?>
                    <small class="text-muted">
                        <?php echo $nayttelijatError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-group row <?php echo !empty($kuvaError)?'alert alert-info':'';?>">
            <label class="col-sm-2 col-form-label text-right">Kuva</label>
            <div class="col-sm-10">
                <input name="kuva" type="text"  placeholder="Kuva" value="<?php echo !empty($kuva)?$kuva:'';?>">
                <?php if (!empty($kuvaError)): ?>
                    <small class="text-muted">
                        <?php echo $kuvaError;?>
                    </small>          
                <?php endif; ?>
            </div>
          </div>

          <div class="form-actions">
              <button type="submit" class="btn btn-success">Lisää</button>
              <a class="btn" href="video.php">Takaisin</a>
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