<?php
    $valikko = 'vuokraus';
    include "header.php";

    // Otetaan tiedosto mukaan joka pitää sisällään luokan, jonka avulla saamme yhteyden tietokantaan.
    require_once 'database.php';
 
    $virheilmoitus = '';

    // Jos käyttäjä on painanut lomakkeen Tallenna vuokraus -painiketta, niin lomakkeen action aktivoituu ja 
    // lähettää lomakkeen sisältämät tiedot POST-metodilla tälle samalle sivulle.
    // Eli if lohkon sisälle mennään vastaa Tallenna vuokraus -painikkeen painamisen jällkeen ei ensimmäisellä kerralla sivulle tultaessa.
    if ( !empty($_POST)) {
        // Luodaat ja alustetaan muuttujat kenttien sisällön tarkistusta varten
        $asiakasError = null;
        $vuokrauspvmError = null;
        $palautuspvmError = null;
		$kokonaishintaError = null;
		$videoError = null;
        $kplHintaError = null;
	
         
        // Luetaan muuttujiin POST-metodin lähettämät tiedot
        $asiakasID = $_POST['asiakasID'];
		$vuokrauspvm = $_POST['vuokrauspvm'];
		$palautuspvm = $_POST['palautuspvm'];
		$kokonaishinta = $_POST['kokonaishinta'];
		$video = $_POST['video'];
		$kplHinta = $_POST['kplHinta'];
		
        $virheilmoitus = '';
        // Tarkistetaan käyttäjän syötteet (tarkistetaan vain että eivät ole tyhjiä). 
        
        $valid = true;
		if (empty($vuokrauspvm)) {
            $virheilmoitus = 'Vuokrauspäivä on tyhjä <br/>';
            $valid = false;
        }
 
		if (empty($palautuspvm)) {
        	$virheilmoitus = $virheilmoitus . ' ' . 'Palautuspäivä on tyhjä <br/>';
         	$valid = false;
        }
		
		if (empty($kokonaishinta)) {
            $virheilmoitus = $virheilmoitus . ' ' . 'Kokonaishinta on tyhjä <br/>';
            $valid = false;
        }
		
		
		if (empty($kplHinta)) {
            $virheilmoitus = $virheilmoitus . ' ' . 'Kpl/hinta on tyhjä <br/>';
            $valid = false;
        }
		
		
        // Kirjoitetaan tiedot tietokannan tauluun, jos kenttien syötteet olivat kunnossa
        // Ohjetaan käyttäjä vuokraus_onnistui.php sivulle
        if ($valid) {
            $pdo = Database::connect();
			$pdo->beginTransaction();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO vuokraus (AsiakasID, vuokrauspvm, palautuspvm, kokonaishinta) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
			$pdo->exec("set names utf8");
            $q->execute(array($asiakasID, $vuokrauspvm, $palautuspvm, $kokonaishinta ));
			
			$vuokrausID = $pdo->lastInsertId();
			foreach( $video as $key => $n ) {
				$sql = "INSERT INTO vuokrausrivi (VuokrausID, videoID, hinta) values(?, ?, ?)";
            	$q = $pdo->prepare($sql);
				$pdo->exec("set names utf8");
            	$q->execute(array($vuokrausID, $video[$key], $kplHinta[$key] ));	
			}

			$pdo->commit();
            Database::disconnect();
            header("Location: ../index.php");
        }
    }

?>

    <div class="container">

<!--
    Lomake vuokraustietojen tallentamista varten
    Lomakkeen yläosassa yleisesti vuokrauksen tiedot
    Lomakkeen alaosassa vuokrattavat videot
    Alaosan videorivejä voi tarvittaessa lisätä tai poistaa
    Huomaa taulukko (array) muuttujien nimeäminen kuten <select name="video[]">
-->
        
        <div class="row">
            <h3>Vuokraustiedot</h3>
        </div>
        <form class="form-horizontal" action="vuokraus.php" method="post">
			<?php if ( $virheilmoitus != '') { 
				echo '<div style="background-color:red;">';
				echo '<p >' . $virheilmoitus .'</p>';
				echo '</div>';
			} ?>
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Asiakas</th>
                        <th>Lainauspvm</th>
                        <th>Palautuspvm</th>
                        <th>Kokonaishinta</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include_once 'database.php';
                    $pdo = Database::connect();
                    $sql = "SELECT asiakasID, CONCAT(etunimi, ' ', sukunimi) kokonimi FROM asiakas ORDER BY sukunimi, etunimi DESC";
                    $pdo->exec("set names utf8");  
                    echo '<tr>';
                        echo '<td>';
                            echo '<select name="asiakasID">';
                            foreach ($pdo->query($sql) as $row) {
                                echo '<option value="' . $row['asiakasID'] . '">' . $row['kokonimi'] . '</option>';
                            }
                            echo '</select>';
                        echo '</td>';
                        echo '<td><input name="vuokrauspvm" type="date" value="' . date('Y-m-d') . '" >';
                        echo '</td>';
                        echo '<td> <input name="palautuspvm" type="date" value="' . date('Y-m-d', strtotime('+1 day')) . '" >';
                        echo '</td>';
                        echo '<td><input name="kokonaishinta" >';
                        echo '</td>';
                    echo '</tr>';
                    
                    Database::disconnect();
                ?>
                </tbody>
            </table>
        </div>
        
        <div class="row">
            <label>Kuinka monta rivi haluat näkyviin:
                <select id="participants" class="input-mini required-entry">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select></label>

            <table class="table table-striped table-bordered" id="participantTable">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Video</th>
                            <th>Hinta</th>
                        </tr>
                    </thead>
                    <tr class="participantRow">
                        <td>&nbsp;</td>
                        <?php
                            include_once 'database.php';
                            $pdo = Database::connect();
                            $sql = "SELECT videoID, nimi FROM video ORDER BY nimi";
                            $pdo->exec("set names utf8");  
                            echo '<td>';
                                echo '<select name="video[]">';
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<option value="' . $row['videoID'] . '">' . $row['nimi'] . '</option>';
                                }
                                echo '</select>';
                            echo '</td>';
                            Database::disconnect();
                        ?>
                        <td><input name="kplHinta[]" id="" type="text" value="5" placeholder="Hinta" class="required-entry">
                          </td>
                        <td><button class="btn btn-danger remove" type="button">Poista</button></td>
                    </tr>
                    <tr id="addButtonRow">
                        <td colspan="4"><center><button class="btn btn-large btn-success add" type="button">Lisää videorivejä</button></center></td>
                    </tr>
            </table>
        </div>
            
        <div class="form-actions">
        	<button type="submit" class="btn btn-success">Tallenna vuokraus</button>
            <a class="btn" href="index.php">Takaisin</a>
        </div>
		
		</form>	
        
    </div> <!-- /container -->

    
<?php
    include "footer.php";
?>