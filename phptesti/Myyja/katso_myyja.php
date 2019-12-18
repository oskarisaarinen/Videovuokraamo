<?php
    // Otetaan tiedosto mukaan joka pitää sisällään luokan, jonka avulla saamme yhteyden tietokantaan.
    require 'database.php';
    $myyjaID = null; // Alustetaan muuttuja.

    // Tarkistetaan, että onko myyjaID parametri välitetty GET-metodilla
    // Jos on niin tallennetaan arvo muuttujaan
    if ( !empty($_GET['myyjaID'])) {
        $myyjaID = $_REQUEST['myyjaID'];
    }
    
    // Jos myyjaID parametriä ei välitetty, palautetaan käyttäjä takaisin myyja.php sivulle
    // Jos välitettiin, niin haetaan taulusta kyseisen asiakkaan tiedot data muuttujaan
    if ( null==$myyjaID ) {
        header("Location: myyja.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");   
        $sql = "SELECT * FROM myyja where myyjaID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($myyjaID));
        $data = $q->fetch(PDO::FETCH_ASSOC);
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

    <!--    Näytetään asiakkaan tiedot readonly tyyppisissä input kentissä käyttäjälle -->
    <div class="container">
     
        <div class="row">
            <h3>Katso myyjätietoja</h3>
        </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Rooli</label>
            <div class="col-sm-10">
                 <input type="text" readonly class="form-control-plaintext" id="statichenkilotunus" 
                    value="<?php echo $data['rooli'];?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Etunimi</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticetunimi" 
                    value="<?php echo $data['etunimi'];?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Sukunimi</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticsukunimi" 
                    value="<?php echo $data['sukunimi'];?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Lähioisoite</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticlahiosoite" 
                    value="<?php echo $data['lahiosoite'];?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Postinumero</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticpostinumero" 
                    value="<?php echo $data['postinumero'];?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Postitoimipaikka</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticpostitoimipaikka" 
                    value="<?php echo $data['postitoimipaikka'];?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Käyttäjätunnus</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticsahkoposti" 
                    value="<?php echo $data['kayttajatunnus'];?>" >
            </div>
          </div> 

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right">Salasana</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticpuhelin" 
                    value="<?php echo $data['salasana'];?>" >
            </div>
          </div> 

          <div>
            <a class="btn" href="myyja.php">Takaisin</a>
          </div>
                 
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