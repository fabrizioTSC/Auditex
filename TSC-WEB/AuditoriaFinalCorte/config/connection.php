<?php
    $local = false;
    if ($local == true) {
        // Use these lines for local MySQL database connections if needed
        // $conn = mysqli_connect('localhost', 'root', '', 'tsc');
        // $conn = mysqli_connect('localhost', 'root', '', 'auditex');
    } else {
        // SQL Server connection settings
        $serverName = '172.16.84.221'; // update this with your SQL Server address or name
        $connectionOptions = array(
            "Database" => "SIGE_AUDITEX_PRUEBA_2", // update this with your database name
            "Uid" => "sa", // update this with your SQL Server username
            "PWD" => 'Developer2024$', // update this with your SQL Server password
            "CharacterSet" => "UTF-8"
        );

        // Establishes the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true)); // Error handling
        }
    }
?>
