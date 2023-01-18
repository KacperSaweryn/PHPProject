<?php
include('Functions.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <script>
        function valid() {
            if (document.forms[0].login.value === '' || document.forms[0].password.value === '') {
                alert('Uzupełnij wszystkie pola')
                return false;
            }
            return true;
        }
    </script>
</head>
<body bgcolor=#add8e6>

<hr>
<center>
    <div>
        <h3>Portal Pacjenta</h3>
    </div>
    <form method=GET action='MainPage.php' onsubmit="return valid()">
        <table border=0>
            <tr>
                <td>Login</td>
                <td colspan=2>
                    <input type=text name='login' size=15 style='text-align: left'></td>
            </tr>
            <tr>
                <td>Hasło</td>
                <td colspan=2>
                    <input type=password name='password' size=15'></td>
            </tr>
            <tr>
                <td colspan=2>
                    <input type=submit value='Zaloguj się' style='width:100%'></td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>

