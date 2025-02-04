<?php
	require_once('admin-login/loader.inc');
    
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if(isset($_GET['handlewishlist'])){
        if($obj['reqId'] == 'n372aoxyf3890qxiul38zawulfu039fuf348rfcwhf'){
            if($obj['phone'] != '' ){
                $find_user = find("first", USER, '*', "WHERE phone = '".$obj['phone']."'", array());
                if($find_user){
                    if($obj['shopid'] != ''){
                        $find_wishlist_status = find("first", WISHLIST, '*', "WHERE shopid = '".$obj['shopid']."' AND userid = '".$find_user['id']."' ", array());
                        if($find_wishlist_status){
                            $table=WISHLIST;
                            $where_clause="WHERE id=".$find_wishlist_status['id'];
                            $execute=array();
                            delete($table, $where_clause, $execute);
                            echo(json_encode('Success'));exit;
                        }
                        else{
                            $table=WISHLIST;
                            $fields="userid,shopid";
                            $values=":userid,:shopid";
                            $execute=array(
                              ':userid'=>$find_user['id'],
                              ':shopid'=>$obj['shopid'],
                              );
                            $save_data = save($table, $fields, $values, $execute);
                            echo(json_encode('Success'));exit;
                        }
                    }
                    else{
                         echo(json_encode('Coin Not Found'));exit;
                    }
                }
                else{
                    echo(json_encode('User Not Found'));exit;
                }
            }
            else{
                echo(json_encode('Invalid User'));exit;
            }
        }
        else{
                echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else if(isset($_GET['favouritspage'])){
        
        if($obj['reqId'] == '65967895b68thhgfbthdurvsd5v65876bginmgj'){
            if($obj['phone'] != '' ){
                $find_user = find("first", USER, '*', "WHERE phone = '".$obj['phone']."'", array());
                if($find_user){
                    $find_user_wishlist = find("all", WISHLIST, '*', "WHERE userid = '".$find_user['id']."'", array());
                    if($find_user_wishlist){
                        $ids = array();
                        foreach($find_user_wishlist as $wishes){
                            array_push($ids,$wishes['shopid']);
                        }
                        $imploded_ids = implode(',',$ids);
                        
                        //echo(json_encode($imploded_ids));exit;
                        
                        $find_shops = find("all", SHOP, '*', "WHERE id IN (".$imploded_ids.") ORDER BY id DESC", array());
                        
                        echo(json_encode($find_shops));exit;
                        
                    }else{
                        echo(json_encode('nodata'));exit;
                    }
                }
                else{
                    echo(json_encode('User Not Found'));exit;
                }
            }
            else{
                echo(json_encode('Invalid User'));exit;
            }
        }
        else{
                echo(json_encode('Invalid Req Id'));exit;
        }
        
    }
    else{
        if($obj['reqId'] == '65967895b68thhgfbthdurvsd5v65876bginmgj'){
            if($obj['phone'] != '' ){
                $find_user = find("first", USER, '*', "WHERE phone = '".$obj['phone']."'", array());
                if($find_user){
                    $find_user_wishlist = find("all", WISHLIST, '*', "WHERE userid = '".$find_user['id']."'", array());
                    
                    if($find_user_wishlist){
                        echo(json_encode($find_user_wishlist));exit;
                    }else{
                        echo(json_encode('nodata'));exit;
                    }
                }
                else{
                    echo(json_encode('User Not Found'));exit;
                }
            }
            else{
                echo(json_encode('Invalid User'));exit;
            }
        }
        else{
                echo(json_encode('Invalid Req Id'));exit;
        }
    }
    

?>