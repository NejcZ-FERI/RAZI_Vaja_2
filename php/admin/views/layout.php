<!DOCTYPE html>
<head>
	<title>Vaja 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body style="background-color: #F5FAFA">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand"><b>Oglasnik</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto flex-nowrap">
                    <li class="nav-item"><a class="nav-link" href="/index.php">Domov</a></li>
                    <?php if (isset($_SESSION["USER_ID"])) { ?>
                        <li class="nav-item"><a class="nav-link" href="/my_ads.php">Moji oglasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="/publish.php">Objavi oglas</a></li>
                        <?php if (isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]) { ?>
                            <li class="nav-item"><a class="nav-link" href="/admin/index.php">Administracija</a></li>
                        <?php } ?>
                        <li class="nav-item"><a class="nav-link" href="/logout.php">Odjava</a></li>
                    <?php } else {
                        header("Location: /index.php");
                    } ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php require_once('routes.php'); ?> 

</body>
</html>