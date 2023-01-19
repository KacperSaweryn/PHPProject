<?php
include($_SERVER['DOCUMENT_ROOT'].'\functions\functions.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Pacjenta</title>
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
                            <span class="nav-link" data-bs-toggle="modal"
                            data-bs-target="#add-visit-modal">Dodaj wizyte +</span>
                        </li>
                        <li class="nav-item"><a href='/pages/login.php' class="nav-link">Wyloguj się <i
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


         <!-- MODAL ADD VISIT START -->
         <form action="">
            <div class="modal fade" id="add-visit-modal" tabindex="-1" role="dialog" aria-labelledby="add-visit-modalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="visit-modalLabel">Dodaj wizyte</h5>
                        </div>
                        <div class="modal-body">
                           
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
                            

                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                            <button type="button" class="btn btn-primary">Zapisz i zamknij</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- MODAL ADD VISIT END -->



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
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">21.12.2022</th>
                            <td>0:30h</td>
                            <td>Jan Kowalski</td>
                            <td>Odbyła się</td>
                            <td><button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal"
                                    data-bs-target="#visit-modal">Edytuj</button></td>
                        </tr>
                        <tr>
                            <th scope="row">21.12.2022</th>
                            <td>0:30h</td>
                            <td>Jan Kowalski</td>
                            <td>Odbędzie się</td>
                            <td><button type="button" class="btn btn-primary btn-block">Edytuj</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- VISITS END -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>