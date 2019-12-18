<?php
    $valikko = 'raportit';
	include 'header.php'; 	 
?>
    <div class="container padding-15">
            <div class="row">
                <h3>Vuokralla olevat videot</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Asiakkaan nimi</th>
                      <th>Videon nimi</th>
                      <th>Vuokrauspäivä</th>
					  <th>Palautuspäivä</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
					$date = date('Y-d-m'); // 2018-30-11
                   include 'database.php';
                   $pdo = Database::connect();
				   $pdo->exec("set names utf8");
                   $sql = "SELECT concat(a.etunimi, ' ', a.sukunimi) asiakkaanNimi, 
				   			vi.nimi videonNimi, v.vuokrauspvm, v.palautuspvm
				   			FROM asiakas a, vuokraus v, vuokrausrivi vr, video vi
							WHERE a.asiakasID = v.asiakasID 
							AND v.vuokrausID = vr.vuokrausID
							AND vr.videoID = vi.videoID
							AND v.palautuspvm >= '" . $date . "'
							ORDER BY palautuspvm ASC";
					  
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['asiakkaanNimi'] . '</td>';
                            echo '<td>'. $row['videonNimi'] . '</td>';
                            echo '<td>'. $row['vuokrauspvm'] . '</td>';
					        echo '<td>'. $row['palautuspvm'] . '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
	
<?php 

	include 'footer.php'; 

?>