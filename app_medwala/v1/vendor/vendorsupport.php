<?php
session_start();

	require_once('loader.inc');
	require "PHPMailer/PHPMailerAutoload.php";
    
	if(isset($_POST['name']))
		{
		     //EMAIL OTP
            $to = 'madhumitadas678@gmail.com';
			$from = "info@servequewebservices.in";
			$from_name = $_POST['email'];
            $name = 'Medwala';
            $subj = 'Support  From '.$_POST['name'].' - Medwala';
           
             $body = '  <div class="tablemail">    
               <h1>Customer Details</h1>
            <table border="1" cellspacing="0" width="100%" class="gmail-table" style="border: solid 2px #DDEEEE;border-collapse: collapse;border-spacing: 0;font: normal 14px Roboto, sans-serif;" >
            <thead>
            <tr>
            <th style="background-color: #DDEFEF;border: solid 1px #DDEEEE;color: #336B6B;padding: 10px;text-align: left;text-shadow: 1px 1px 1px #fff;">Name</th>
            <th style="background-color: #DDEFEF;border: solid 1px #DDEEEE;color: #336B6B;padding: 10px;text-align: left;text-shadow: 1px 1px 1px #fff;">Email</th>
            <th style="background-color: #DDEFEF;border: solid 1px #DDEEEE;color: #336B6B;padding: 10px;text-align: left;text-shadow: 1px 1px 1px #fff;">Phone</th>
            <th style="background-color: #DDEFEF;border: solid 1px #DDEEEE;color: #336B6B;padding: 10px;text-align: left;text-shadow: 1px 1px 1px #fff;">Message</th>
            </tr>
             </thead>
               <tbody>
            <tr>
            <td style="text-align:center;border: solid 1px #DDEEEE;color: #333;padding: 10px;text-shadow: 1px 1px 1px #fff;">'.$_POST['name'].'</td> 
            <td style="text-align:center;border: solid 1px #DDEEEE;color: #333;padding: 10px;text-shadow: 1px 1px 1px #fff;">'.$_POST['email'].'</td> 
            <td style="text-align:center;border: solid 1px #DDEEEE;color: #333;padding: 10px;text-shadow: 1px 1px 1px #fff;">'.$_POST['phn'].'</td> 
            <td style="text-align:center;border: solid 1px #DDEEEE;color: #333;padding: 10px;text-shadow: 1px 1px 1px #fff;">'.$_POST['msg'].'</td> 
            </tr>
              </tbody>
            </table>
            </div>';
            $error=smtpmailer($to,$from, $name ,$subj, $body);
            //EMAIL OTP
            echo('done');exit;
		}
?>