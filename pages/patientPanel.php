<?php
include('../functions/functions.php');
include('../components/visitsList.php');
include('../functions/welcome.php');
session_start();
$userId = $_SESSION['userId'];
openConnection();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel pacjenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../styles/styles.css" rel="stylesheet">
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</head>

<body>

<section>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container d-flex justify-content-between">
            <div class="navbar-brand">Przychodnia</div>
            <div id="ftco-nav">
                <ul class="navbar-nav" id="myTab" role="tablist">
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
<div class="tab-content" id="myTabContent">

    <!-- VISITS START -->
    <div class="container">
        <div class="tab-pane fade show active" id="visitsList" role="tabpanel" aria-labelledby="visits-tab"
             tabindex="0">

            <h2>Lista wizyt</h2>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Data wizyty</th>
                    <th scope="col">Czas wizyty</th>
                    <th scope="col">Pacjent</th>
                    <th scope="col">Lekarz</th>
                    <th scope="col">Opis</th>
                    <th scope="col"></th>

                </tr>
                </thead>
                <tbody>
                <?php
                visitsList($userId);
                ?>
                </tbody>
            </table>

        </div>
    </div>
    <!-- VISITS END -->
    <?php
    closeConnection();
    ?>
</body>
<footer>
    <div class="container">
        <?php
        welcome($userId);
        ?>
    </div>
</footer>
</html>