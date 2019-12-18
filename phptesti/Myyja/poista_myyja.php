<?php
 // Otetaan tiedosto mukaan joka pitää sisällään luokan, jonka avulla saamme yhteyden tietokantaan.
    require 'database.php';
    $myyjaID = null; // Alustetaan myyjaID muuttuja

    // Tarkistetaan, että onko myyjaID parametri välitetty GET-metodilla
    // Jos on niin tallennetaan arvo muuttujaan
    if ( !empty($_GET['myyjaID'])) {
        $myyjaID = $_REQUEST['myyjaID'];
        
        // Haetaan kyseisen asiakkaan tiedot data muuttujaan
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM myyja WHERE myyjaID = ?";
        $q = $pdo->prepare($sql);
        $pdo->exec("set names utf8");
        $q->execute(array($myyjaID));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }

    // Tarkistetaan, että onko käyttäjä painanut lomakkeet Kyllä-painiketta
    // Tallennetaan piilotetun (input kentän type="hidden") kentän arvo muuttujaan myyjaID
    if ( !empty($_POST)) {
        $myyjaID = $_POST['myyjaID'];
         
        // Poistetaan kyseisen asiakkaan tiedot tietokannasta
        // Tiedon eheys jatkossa muiden taulujen osalta?
        // Ohjataan käyttäjä lopuksi pääsivulle
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM myyja WHERE myyjaID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($myyjaID));
        Database::disconnect();
        header("Location: myyja.php");
         
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
            <h3>Poista myyjatietoja</h3>
        </div>

        <form action="poista_myyja.php" method="post">
          <input type="hidden" name="myyjaID" value="<?php echo $myyjaID;?>"/>
          <p class="alert alert-warning">Haluatko varmasti poistaa myyjan <?php echo $data['etunimi'] .  ' ' . $data['sukunimi'] ; ?> tiedot?</p>
          <div>
              <button type="submit" class="btn btn-danger">Kyllä</button>
              <a class="btn" href="myyja.php">Ei</a>
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