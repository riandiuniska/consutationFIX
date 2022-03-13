<?php
    require "./db/Ports.php";
    
    $objPort = new Ports;
    $objPort->set_group_id($_POST['group_id']);
    $portsData = $objPort->get_port_by_group_id();

    if(!empty($portsData)) {
        echo $portsData['value'];
    } else {
        $objPort->set_status(0);
        $port = $objPort->get_all_free_port();
        
        if(!empty($port)) {
            foreach($port as $key => $port) {
                if($port['status'] == 0) {
                    $freePort = $port['value'];
                    break;
                }
            }
            $objPort->set_status(1);
            $objPort->set_group_id($_POST['group_id']);
            $objPort->set_value($freePort);
            $objPort->update_port_status();
            echo $freePort;
        } else {
            echo "Port is full!";
        }
    }

    
    
    