<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Videovuokraamo</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/carousel/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/carousel/carousel.css" rel="stylesheet">
  </head>
  <body>

  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="../index.php">Videovuokraamo</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">

                <ul class="navbar-nav mr-auto">

                     <?php


                    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                        echo '<li class="nav-item '; 
                        echo ($valikko==='asiakas')?'active':'';
                        echo ' ">
                            <a class="nav-link" href="/Asiakas/asiakas.php">Asiakas <span class="sr-only">(current)</span></a>
                        </li>';
                        echo '<li class="nav-item '; 
                        echo ($valikko==='video')?'active':'';
                        echo ' ">
                            <a class="nav-link" href="/Video/video.php">Video</a>
                        </li>';
                        echo '<li class="nav-item '; 
                        echo ($valikko==='vuokraus')?'active':'';
                        echo ' ">
                            <a class="nav-link" href="/Vuokraus/vuokraus.php">Vuokraus</a>
                        </li>';
                        echo '<li class="nav-item '; 
                        echo ($valikko==='myyja')?'active':'';
                        echo ' ">
                            <a class="nav-link" href="/Myyja/myyja.php">Myyjä</a>
                        </li>
                        <li class="nav-item dropdown ';
                        echo ($valikko==='raportit')?'active':'';
                        echo ' ">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Raportit
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/phptesti/Vuokraus/vuokralla.php">Vuokralla</a>

                            </div>
                        </li>';
                    }
                    ?>
                </ul>

            <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Syötä hakusana" aria-label="Search">

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Haku</button>    
            </form>

            <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                echo '<a class="nav-link" href="Kirjautuminen/ulos.php">Ulos <span class="oi oi-account-logout"></span></a>';
            } else {
                echo '<a class="nav-link" href="sisaan.php">Kirjaudu <span class="oi oi-account-login"></span></a>';
            }
            ?>    

        </div>
    </nav>
</header>

