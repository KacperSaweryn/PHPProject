<?php
include('../functions/functions.php');
include('../functions/welcome.php');
include('../components/visitsList.php');
session_start();
$userId = $_SESSION['userId'];
$lastVisit = $_COOKIE['lastVisit'] ?? "";
setcookie('lastVisit', date('d/m/y - G:i'), time() + (60 * 60 * 12 * 365));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../styles/styles.css" rel="stylesheet">
</head>

<body>

<section>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <div class="navbar-brand">Przychodnia</div>

            <div id="ftco-nav">
                <ul class="navbar-nav" id="myTab" role="tablist">
                    <li class="nav-item menu-item" role="presentation"><a href='visitPanel.php'
                                                                          class="nav-link">Wizyty </a></li>
                    </li>
                    <li class="nav-item menu-item" role="presentation"><a href='../pages/usersPanel.php'
                                                                          class="nav-link">Użytkownicy </a></li>

                    <li class="nav-item"><a href='../functions/logout.php' class="nav-link">Wyloguj się <i
                                    class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
<footer>

    <div class="container">
        <?php
        welcome($userId);
        ?>
    </div>
    <div class="container">
        <?php
        getLastVisit($lastVisit);
        ?>
    </div>
</footer>
</body>

</html>