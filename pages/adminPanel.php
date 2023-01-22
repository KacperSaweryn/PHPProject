<?php
// include($_SERVER['DOCUMENT_ROOT'].'\functions\functions.php');
include('../functions/functions.php');
include('../components/visitsList.php');
include('../components/usersList.php');
include("C:/xampp/htdocs/PHPProject/CRUD/init.php");
session_start();

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
        <div class="container d-flex justify-content-between">
            <div class="navbar-brand">Przychodnia</div>
            <div id="ftco-nav">
                <ul class="navbar-nav" id="myTab" role="tablist">
                    <li class="nav-item menu-item" role="presentation">
                            <span class="nav-link active" id="visits-tab" data-bs-toggle="tab"
                                  data-bs-target="#visitsList" role="tab" aria-controls="visitsList"
                                  aria-selected="true">Wizyty</span>
                    </li>
                    <li class="nav-item menu-item" role="presentation">
                            <span class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#userList"
                                  role="tab" aria-controls="userList" aria-selected="false">Uzytkownicy</span>
                    </li>
                    <li class="nav-item"><a href='/functions/logout.php' class="nav-link">Wyloguj się <i
                                    class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

</section>

<div class="container">
    <!-- MODAL VISIT START -->
    <form action="">
        <div class="modal fade" id="visit-modal" tabindex="-1" role="dialog" aria-labelledby="visit-modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visit-modalLabel">Edytuj wizyte</h5>
                    </div>
                    <div class="modal-body">
                        <label for="patient">Pacjent</label>
                        <input type="text" class="form-control" id="patient" placeholder="Pacjent"
                               aria-label="Pacjent" aria-describedby="basic-addon1">
                        <label for="date">Data</label>
                        <input type="date" class="form-control" id="date">

                        <select class="form-select">
                            <option selected>--- Wybierz godzine ---</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <label for="time">Czas wizyty (w minutach)</label>
                        <input type="text" class="form-control" id="time" placeholder="Czas wizyty"
                               aria-describedby="basic-addon1">
                        <span>Status</span>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                   id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Odbyła się
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                   id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Odbędzie się
                            </label>
                        </div>

                        <div class="form-floating">

                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Opis</label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="button" class="btn btn-primary">Zapisz i zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- MODAL VISIT END -->


    <!-- MODAL USER START -->
    <form action="">
        <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="user-modalLabel">Edytuj uzytkownika</h5>
                    </div>
                    <div class="modal-body">
                        <label for="name">Imię</label>
                        <input type="text" class="form-control" id="name" placeholder="Imię">
                        <label for="surname">Nazwisko</label>
                        <input type="text" class="form-control" id="surname" placeholder="Nazwisko">


                        <select class="form-select">
                            <option selected>--- Wybierz typ ---</option>
                            <option value="doctor">Lekarz</option>
                            <option value="patient">Pacjent</option>
                            <option value="admin">Admin</option>
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="button" class="btn btn-primary">Zapisz i zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- MODAL USER END -->



    <div class="tab-content" id="myTabContent">
        <!-- VISITS START -->
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
                    visitsList();
                ?>
                </tbody>
            </table>
        </div>
        <!-- VISITS END -->



        <!-- USERS START -->
        <div class="tab-pane fade" id="userList" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
            <h2>Lista uzytkowników</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Typ</th>
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
               
                    <?php
                        usersList();
                    ?>
                
                </tbody>
            </table>

        </div>
        <!-- USERS END -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>