#!/usr/bin/env php

<?php

    $pushTest = false;
    $backofficeTest = true;

    require "./src/Siberian/Api.php";
    require "./src/Siberian/Application.php";
    require "./src/Siberian/Request.php";
    require "./src/Siberian/Response.php";
    require "./src/Siberian/User.php";
    require "./src/Siberian/Push.php";
    require "./src/Siberian/Backoffice.php";

    // API init
    require "./tests/init.php";

    require "./tests/user.php";
    require "./tests/application.php";
    require "./tests/backoffice.php";
    require "./tests/push.php";
