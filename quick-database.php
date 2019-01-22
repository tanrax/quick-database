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
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let colors = [
                    [9,35,39],
                    [11,83,81],
                    [0,169,165],
                    [78,128,152],
                    [144,194,231],
                    [255,128,0]
                ];

                let step = 0;
                // current color left
                // next color left
                // current color right
                // next color right
                let colorIndices = [0,1,2,3];

                //transition speed
                let gradientSpeed = 0.002;

                function updateGradient() {
                let c0_0 = colors[colorIndices[0]];
                let c0_1 = colors[colorIndices[1]];
                let c1_0 = colors[colorIndices[2]];
                let c1_1 = colors[colorIndices[3]];

                let istep = 1 - step;
                let r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
                let g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
                let b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
                let color1 = "rgb("+r1+","+g1+","+b1+")";

                let r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
                let g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
                let b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
                let color2 = "rgb("+r2+","+g2+","+b2+")";

                document.documentElement.style.setProperty('--color-gradient-1', color1);
                document.documentElement.style.setProperty('--color-gradient-2', color2);
                  
                  step += gradientSpeed;
                  if ( step >= 1 )
                  {
                    step %= 1;
                    colorIndices[0] = colorIndices[1];
                    colorIndices[2] = colorIndices[3];
                    
                    //pick two new target color indices
                    //do not pick the same as the current one
                    colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
                    colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
                    
                  }
                }

                setInterval(updateGradient, 10);
            });
        </script>
        <style type="text/css">

            :root {
                --color-gradient-1: #fff;
                --color-gradient-2: #fff;
                --color-black: #000000;
                --color-blue: #14213d;
                --color-platinum: #e5e5e5;
                --color-white: #ffffff;
                --color-red: #ff6b6b;
                --color-green: #0ead69;
            }

            body {
                margin: 0;
                background-image: linear-gradient(to bottom right, var(--color-gradient-1), var(--color-gradient-2));
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
