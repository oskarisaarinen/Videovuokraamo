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
    <h3>Videotiedot</h3>
</div>
<div class="row">
    <p>
        <a href="lisaa_video.php" class="btn btn-success">Lisää</a>
    </p>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Genre</th>
                <th>Kesto</th>
                <th>Toiminto</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Luodaan yhteys tietokantaan ja haetaan video-taulusta
            // asiakkaiden tiedot omiin sarakkaisiin.
            // Lopuksi katkaistaan yhteys tietokantaan.
            include 'header.php';
            include 'database.php';
            $pdo = Database::connect();
            $sql = 'SELECT * FROM video ORDER BY nimi, genre DESC';
            $pdo->exec("set names utf8");      
            foreach ($pdo->query($sql) as $row) {
                                    //echolla tulostetaan dynaamista sisältöä sivulle.
                echo '<tr>';
                echo '<td>'. $row['nimi'] . '</td>';
                echo '<td>'. $row['genre'] . '</td>';
                echo '<td>'. $row['kesto'] . '</td>';
                echo '<td><a class="btn" href="katso_video.php?videoID='.$row['videoID'].'">Katso</a> ';
                echo ' ';
                echo '<a class="btn btn-success" href="paivita_video.php?videoID='.$row['videoID'].'">Päivitä</a>';
                echo ' ';
                echo '<a class="btn btn-danger" href="poista_video.php?videoID='.$row['videoID'].'">Poista</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
        ?>
        </tbody>
    </table>
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

