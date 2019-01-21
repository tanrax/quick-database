<?php

//======================================================================
// VARIABLES
//======================================================================
$host = isset($_REQUEST['host']) ? $_REQUEST['host'] : '';
$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
$newDatabase = isset($_REQUEST['new-database']) ? $_REQUEST['new-database'] : '';
$success = false;
$error = false;

//======================================================================
// CREATE DATABASE
//======================================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Connect
        $hostPDO = "mysql:host=$host;";
        $myPDO = new PDO($hostPDO, $username, $password);
        // Execute
        $query = $myPDO->prepare("CREATE DATABASE $newDatabase DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;");
        //$query->execute();

        $success = true;
    } catch (PDOException $e) {
        $error = true;
    }
}

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Quick-database | Fast database creator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="author" content="Andros Fenollosa">			
        <style type="text/css">

            :root {
                --color-black: #000000;
                --color-blue: #14213d;
                --color-platinum: #e5e5e5;
                --color-white: #ffffff;
                --color-red: #ff6b6b;
                --color-green: #0ead69;
            }

            body {
                margin: 0;
                background-image: linear-gradient(to bottom right, var(--color-platinum), var(--color-blue));
                font-family: Arial;
            } 

            main {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                width: 100vw;
            }

            .form {
                display: flex;
                flex-direction: column;
                max-width: 20rem;
                box-shadow: 0em 0em 1rem var(--color-black);
                background-color: var(--color-white);
                border-radius: .4rem;
            }

            .form .form--title {
                color: var(--color-blue);
                font-size: 1.3rem;
                text-align: center;
                margin: 2rem;
                margin-bottom: 1rem;
            }

            .form input {
                padding: .5rem;
                margin-top: 1rem;
                margin: .6rem 1.5rem;
                border-color: var(--color-platinum);
                border-style: solid;
                transition: .3s all;
            }

            .form input:focus {
                border-color: var(--color-blue);
            }

            .form .form--submit {
                background-color: var(--color-blue);
                color: var(--color-white);
                border: 0;
                margin: 0;
                margin-top: 1rem;
                padding: 1rem;
                text-transform: uppercase;
                transition: .3s all;
            } 

            .form .form--submit:hover {
                filter: brightness(1.4);
                cursor: pointer;
            }

            .form .success {
                background-color: var(--color-green);
            }

            .form .error {
                background-color: var(--color-red);
            }
        </style>
    </head>	
    <body>
        <main>
            <form class="form" action="" method="post">
                <h1 class="form--title">Quick database (MySQL)</h1>
                <input id="host" type="text" name="host" placeholder="Host MySQL" value="<?= $host ?>">
                <input id="username" type="text" name="username" placeholder="Username MySQL" value="<?= $username ?>">
                <input id="password" type="password" name="password" placeholder="Password MySQL" value="<?= $password ?>">
                <input id="new-database" type="text" name="new-database" placeholder="Name new database" value="<?= $newDatabase ?>">
                <input class="form--submit<?= $success ? ' success' : ($error ? ' error' : '') ?>" type="submit" value="<?= $success ? 'Success' : ($error ? 'Error' : 'Create') ?>"<?= $success ? ' disabled' : '' ?>>
            </form>
        </main>
    </body>	
</html>
