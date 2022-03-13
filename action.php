<?php
    require "./db/Ports.php";
    
    $objPort = new Ports;
    $objPort->set_status(0);
    $port = $objPort->get_all_free_port();
    // $freePort = 0;
    foreach($port as $key => $port) {
        if($port['status'] == 0) {
            $freePort = $port['value'];
        }
    }
    echo $freePort;