<?php
	session_start();
	
	//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
	if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800) {
		session_regenerate_id(true);
	}

	$_SESSION['LAST_ACTIVITY'] = time();
	
	//Poveži se z bazo
	$conn = new mysqli('localhost', 'root', '', 'vaja1');
	//Nastavi kodiranje znakov, ki se uporablja pri komunikaciji z bazo
	$conn->set_charset("UTF8");
?>

<html lang="sl">
<head>
	<title>Vaja 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: #F5FAFA">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand"><b>Oglasnik</b></a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Domov</a></li>
                <?php
                if (isset($_SESSION["USER_ID"])) {
                    ?>
                    <li class="nav-item"><a class="nav-link" href="my_ads.php">Moji oglasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="publish.php">Objavi oglas</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Odjava</a></li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Prijava</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Registracija</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
	</nav>