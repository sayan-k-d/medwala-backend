<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if(isset($_GET['DeletePrescription'])){
        if($obj['reqId'] == 'c7n2c8723yx72ym8923u8m92xm833du28d'){
            if($obj['precriptionid'] != ''){
                
                $table=SAVEDPRESCRIPTIONS;
                $where_clause="WHERE id=".$obj['precriptionid'];
                $execute=array();
                $delete = delete($table, $where_clause, $execute);
    	        if($delete){
        		    echo(json_encode('Success'));exit;
        		}
        		else{
        		    echo(json_encode('Unable To Delete Prescription'));exit;
        		}
            }
            else
            {
                echo(json_encode('Invalid Prescription ID'));exit;
            } 
        }
        else
        {
            echo(json_encode('Invalid Reqid'));exit;
        } 
    }
    else if(isset($_GET['getPrescriptionPhotos'])){
        if($obj['reqId'] == 'mc8w489tmc7tm839389mu3mu8ux9348mu3'){
            if($obj['quoteid'] != ''){
                $find_admin = find("all", PRESCRIPTIONS, '*', "WHERE quoteid = '".$obj['quoteid']."' AND type = 'Saved' ORDER BY id ASC", array());
        	    
                $b = [];
                
                foreach ($find_admin as $key => $value) {
                    $b[$key] = $value['image'];
                }
            
            	echo json_encode($b);exit;
            }
            else
            {
                echo(json_encode('Invalid Quoteid'));exit;
            } 
        }
        else
        {
            echo(json_encode('Invalid Reqid'));exit;
        } 
    }
    else if(isset($_GET['renamePrescription'])){
        if($obj['reqId'] == '71x6e7e26x712ny189z2a9ue8ankcneozldjsi'){
            if($obj['presid'] != '' && $obj['presname'] != '' ){
                //echo(json_encode($obj['presname']));exit;
                $table=SAVEDPRESCRIPTIONS;
        		$set_value="name=:name";
        		$where_clause="WHERE id=".$obj['presid'];
        		$execute=array(
        		':name'=>$obj['presname'],
        		);
        		$update=update($table, $set_value, $where_clause, $execute);
        		//print_r($update);exit;
        		if($update)
        		{
        			echo(json_encode('done'));exit;
        		}
        		else
        		{
        			echo(json_encode('Sorry! Unable To Edit. Try Back Later'));exit;
        		}
            }
            else
            {
                echo(json_encode('Invalid Prescription'));exit;
            } 
        }
        else
        {
            echo(json_encode('Invalid Reqid'));exit;
        } 
    }
    else{
        if($obj['reqId'] == '8237rx9823r79n83892krxu3u29rasu32nu823brmxy23'){
            $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
            if($find_admin){
                $find_prescriptions = find("all", SAVEDPRESCRIPTIONS, '*', "WHERE userid = '".$find_admin['id']."' ", array());
                if($find_prescriptions){
                    echo(json_encode($find_prescriptions));exit;
                }
                else{
                    echo(json_encode('nodata'));exit;
                }
            }
            else{
                   echo(json_encode('Invalid User'));exit;
            }
        }
        else
        {
            echo(json_encode('Invalid Reqid'));exit;
        }   
    }
    
?>