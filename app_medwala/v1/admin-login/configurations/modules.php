<?php
/*
=========================================================================================================================
COPYRIGHT: NEOCODERZ TECHNOLOGIES
PRODUCT NAME: TRAVEL PORTAL
PAGE NAME: MODULES.PHP
PAGE FUNCTIONALITY: THIS FILE CONSISTS OF DEFINATIONS OF ALL MODULES THAT ARE BEEN USED THROUGHOUT THE PRODUCT.
=========================================================================================================================
*/

/*
function verify_token()

* validate whether only valid for fields are posted. This function will prevent forcefully added form hidden fields to be posted.
* $white_list_array: array_of from fieldname.
* $post_date: date posted through from using POST method.
* return true if success or false is invalid.
* $verify_token: Fixed defined token for each from.
* returnds true if matching found, otherwise returnds false.
*/

function verify_token($white_list_array, $post_date, $verify_token)
{
	$security_flag = true;
	foreach($post_date AS $key=>$value)
	{
		if(!in_array($key, $white_list_array))
		{
			$security_flag = false;
			break;
		}
	}
	if(verifyFormToken($verify_token) && $security_flag) 
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*
function module_login()

* check the login authentication.
* $param1: Username or email address of the account
* $param2: Password of the account
* $param3: optional, mostly used as status valiable
* $table_name: name of the table to which you need to validate
* return true if success or false is invalid.
*/

function module_login($param1, $param2, $param3 = null, $table)
{
	$password = hash_password($param2);

	if($param3!='')
	{
		$where_clause = "WHERE (username = '".stripcleantohtml($param1)."' OR email = '".stripcleantohtml($param1)."') AND password = '".stripcleantohtml($password)."' AND status = ".$param3."";
	}
	else
	{
		$where_clause = "WHERE (username = '".stripcleantohtml($param1)."' OR email = '".stripcleantohtml($param1)."') AND password = '".stripcleantohtml($password)."'";
	}
	if($login_check = find("first", $table, $value='*', $where_clause, array()))
	{
		$_SESSION['SESSION_DATA'] = $login_check;
		return true;
	}
	else
	{
		return false;
	}
}

/*
function module_logout($redirect_path)

* logout from application
* @param string destination path
* @return: NONE. Redirect user to the provided destination path
*/

function module_logout($destination_path)
{
	if(count($_SESSION))
	{
		foreach($_SESSION AS $key=>$value)
		{
			session_unset($_SESSION[$key]);
		}
		session_destroy();
	}
	
	header("location:".$destination_path);
}

/*
function module_validation_check($checkingVariable, $destinationPat)

* check whether the page is accessable without login or not.
* @param string checkingVariable: Consists of the variable value based on whcih validation needs to be done.
* @return: If true redirects user to the destination path, otherwise return true.
*/

function module_validation_check($checkingVariable, $destination_path)
{
	if($checkingVariable =='')
	{
		module_logout($destination_path);
	}
}

/*
function module_forgot_password()

* check email authentication and if valid update password and send new password through email.
* $param1: Username or email address of the account
* $param2: Password of the account
* $param3: optional, mostly used as status valiable
* $table_name: name of the table to which you need to validate
* return true if success or false is invalid.
*/

function module_forgot_password($param1, $table)
{
	$where_clause = "WHERE (username = '".stripcleantohtml($param1)."' OR email = '".stripcleantohtml($param1)."')";

	if($validation_check = find("first", $table, $value = 'id,first_name,last_name, username, email', $where_clause, array()))
	{
		$new_password = create_password(5);
		$password = hash_password($new_password);
		
		$template_details = find("first", EMAIL_TEMPLATES, $value='email_subject,title,template_content', "WHERE id = '4'", array());
		 $mail_email_template=$template_details['template_content'];
		 if($mail_email_template!='')
			{
			  $mailbody=str_replace("[FIRSTNAME]",$validation_check['first_name'],$mail_email_template);
			  $mailbody1=str_replace("[LASTNAME]",$validation_check['last_name'],$mailbody);

			  $mailbody2=str_replace("[PASSWORD]",$password,$mailbody1);
			}
			//ECHO $mailbody2;
//EXIT;

		if(update($table, "password=:password", "WHERE id = ".$validation_check['id']."", array(':password'=>$password)))
		{
			//$website_settings = find("first", PORTAL_SETTINGS, $value='from_email_address', "WHERE id = 1", array());

			



			//$mail_body = "Dear ".$validation_check['username'].",<br/><br/>You have requested for new password for your account. Here is your new access details.<br/><br/><b>USERNAME: </b>".$validation_check['username']."<br/><b>PASSWORD: </b>".$new_password."<br/><br/>Please note this is a temporary password that has been reandomly generated. Please change this password to your preferred one once you login to the portal.<br/><br/>Best Regards,<br/>ADMINISTRATOR,<br/>".PRODUCT_NAME."<br/>".DOMAIN_NAME_PATH."";
			//echo $mail_body;exit;
			$mail_body =$mailbody2;
			@Send_HTML_Mail($validation_check['email'], '', 'Your Updated Account Access Details', $mail_body);
			return true;
		}
	}
	else
	{
		return false;
	}
}

/*
function module_counter($where_clause, $table)

* this function will count or sum the data for you and return count value.
* $param1: Username or email address of the account
* $param2: Password of the account
* $param3: optional, mostly used as status valiable
* $table_name: name of the table to which you need to validate
* return true if success or false is invalid.
*/

function module_counter($type, $field_to_count, $where_clause, $table)
{
	$where_clause = "WHERE ".$where_clause;

	if($type == "COUNT")
	{
		if($count_data = find("first", $table, $value = 'count('.$field_to_count.') AS COUNT_VAL', $where_clause, array()))
		{
			return $count_data['COUNT_VAL'];
		}
		else
		{
			return false;
		}
	}
	if($type == "SUM")
	{
		if($count_data = find("first", $table, $value = 'SUM('.$field_to_count.') AS COUNT_VAL', $where_clause, array()))
		{
			return $count_data['COUNT_VAL'];
		}
		else
		{
			return false;
		}
	}
	if($type == "AVG")
	{
		if($count_data = find("first", $table, $value = 'AVG('.$field_to_count.') AS COUNT_VAL', $where_clause, array()))
		{
			return $count_data['COUNT_VAL'];
		}
		else
		{
			return false;
		}
	}
}

/*
function module_currency($type, $currency_id = 'null', $table)

* this function find and rerurns either all available currencies or specific currency search for.
* $type: it can be either 'FETCH' or 'FIND' If 'FETCH' will return all active currencies. If 'FIND' will rerurn specific currency details.
* $currency_id: specific currency id you are searching for. It can be null.
* $table: name of the database table.
* return array of data if found otherwise false.
*/

function module_currency($type, $currency_id = 'null', $table)
{
	if($type == 'FETCH')
	{
		$where_clause = "WHERE status = 1 ORDER BY serial_number";

		if($currency_data = find("all", $table, $value = 'id, currency_name, currency_code', $where_clause, array()))
		{
			//echo $currency_data;
			return $currency_data;
		}
		else
		{
			return false;
		}
	}
	if($type == 'FIND')
	{
		$where_clause = "WHERE id = ".$currency_id." AND status = 1";

		if($currency_data = find("first", $table, $value = 'id, currency_name, currency_code', $where_clause, array()))
		{
			return $currency_data;
		}
		else
		{
			return false;
		}
	}
}

/*
function module_country($type, $currency_id = 'null', $table)

* this function find and rerurns either all available countries or specific countries search for.
* $type: it can be either 'FETCH' or 'FIND' If 'FETCH' will return all active countries. If 'FIND' will rerurn specific countries details.
* $country_id: specific countries id you are searching for. It can be null.
* $table: name of the database table.
* return array of data if found otherwise false.
*/

function module_country($type, $country_id = 'null', $table)
{
	if($type == 'FETCH')
	{
		$where_clause = " WHERE 1";

		if($country_data = find("all", $table, $value = 'id, sortname, name', $where_clause, array()))
		{
			return $country_data;
		}
		else
		{
			return false;
		}
	}
	if($type == 'FIND')
	{
		$where_clause = "WHERE id = ".$country_id."";

		if($country_data = find("first", $table, $value = 'id, sortname, name', $where_clause, array()))
		{
			return $country_data;
		}
		else
		{
			return false;
		}
	}
}

/*
function module_state($type, $state_id = 'null', $country_id = 'null', $table)

* this function find and rerurns either all available states or specific states search for or state lists for a specific country.
* $type: it can be either 'FETCH' or 'FIND' If 'FETCH' will return all active states. If 'FIND' will rerurn specific states details.
* $state_id: specific states id you are searching for. It can be null.
* $country_id: specific country id you are searching all the states of taht country. It can be null.
* $table: name of the database table.
* return array of data if found otherwise false.
*/

function module_state($type, $state_id = 'null', $country_id = 'null', $table)
{
	if($type == 'FETCH')
	{
		if($country_id!='')
		{
			$where_clause = "WHERE country_id = ".$country_id."";

			if($state_data = find("all", $table, $value = 'id, name, country_id', $where_clause, array()))
			{
				return $state_data;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$where_clause = "WHERE 1";

			if($state_data = find("all", $table, $value = 'id, name, country_id', $where_clause, array()))
			{
				return $state_data;
			}
			else
			{
				return false;
			}
		}
	}
	if($type == 'FIND')
	{
		$where_clause = "WHERE id = ".$state_id."";

		if($state_data = find("first", $table, $value = 'id, name, country_id', $where_clause, array()))
		{
			return $state_data;
		}
		else
		{
			return false;
		}
	}
}

/*
function module_city($type, $city_id = 'null', $state_id = 'null', $table)

* this function find and rerurns either all available cities or specific city search for or cities lists for a specific state.
* $type: it can be either 'FETCH' or 'FIND' If 'FETCH' will return all active cities. If 'FIND' will rerurn specific cities details.
* $city_id: specific cities id you are searching for. It can be null.
* $state_id: specific state id for which you need city listing
* $table: name of the database table.
* return array of data if found otherwise false.
*/

function module_city($type, $city_id = 'null', $state_id = 'null', $table)
{
	if($type == 'FETCH')
	{
		if($state_id!='')
		{
			$where_clause = "WHERE state_id = ".$state_id."";

			if($city_data = find("all", $table, $value = 'id, name, state_id', $where_clause, array()))
			{
				return $city_data;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$where_clause = "WHERE 1";

			if($city_data = find("all", $table, $value = 'id, name, state_id', $where_clause, array()))
			{
				return $city_data;
			}
			else
			{
				return false;
			}
		}
	}
	if($type == 'FIND')
	{
		$where_clause = "WHERE id = ".$city_id."";

		if($city_data = find("first", $table, $value = 'id, name, state_id', $where_clause, array()))
		{
			return $city_data;
		}
		else
		{
			return false;
		}
	}
}

/*
function module_form_submission($file_json, $table)

* this function used to insert / update form data into database.
* $file_json: this is a json data that will consists of lists of uploaded file name and path.
* $table: name of the database table.
* return last inserted id if successfully data is been inserted, return false otherwise.
* file_json format:
* IMAGE: {"uploaded_file_data":[{"form_field_name":"restaurant_logo","form_field_name_hidden":"restaurant_logo_hidden","file_path":"../assets/vendor_logo","width":"","height":"","file_type":"image"}]}
* FILE: {"uploaded_file_data":[{"form_field_name":"restaurant_logo","form_field_name_hidden":"restaurant_logo_hidden","file_path":"../assets/vendor_logo","width":"","height":"","file_type":"file"}]}
* ALL: {"uploaded_file_data":[{"form_field_name":"restaurant_logo","form_field_name_hidden":"restaurant_logo_hidden","file_path":"../assets/vendor_logo","width":"","height":"","file_type":"all"}]}
*/

function module_form_submission($file_json, $table)
{
	$flag_check = "VALID";
	$db_field_array = array();
	$field_data = "";
	$values_data_insert = "";
	$values_data_update = "";
	$execute_data = array();

	if($file_json!= '')
	{
		$decoded_file_data = json_decode($file_json, true);

		foreach($decoded_file_data['uploaded_file_data'] AS $uploaded_file_info)
		{
			if(isset($uploaded_file_info['form_field_name_hidden']) && $uploaded_file_info['form_field_name_hidden']!='')
			{
				if($_FILES[''.$uploaded_file_info['form_field_name'].'']['name']!='')
				{
					$position_of_dot = strrpos($_FILES[''.$uploaded_file_info['form_field_name'].'']['name'],'.');
					$extension = substr($_FILES[''.$uploaded_file_info['form_field_name'].'']['name'], $position_of_dot+1);
					if($uploaded_file_info['file_type'] == 'image')
					{
						$validation_array = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
						if(in_array(strtolower($extension), $validation_array))
						{
							$flag_check = "VALID";
						}
						else
						{
							$flag_check = "INVALID";
							return $flag_check;
						}
					}
					if($uploaded_file_info['file_type'] == 'file')
					{
						$validation_array = array('exc', 'dmf', '.zip', 'tar.gz', 'rar', 'jpg', 'jpeg', 'png', 'gif', 'bmp');
						if(!in_array(strtolower($extension), $validation_array))
						{
							$flag_check = "VALID";
						}
						else
						{
							$flag_check = "INVALID";
							return $flag_check;
						}
					}
					if($uploaded_file_info['file_type'] == 'all')
					{
						$validation_array = array('exc', 'dmf', '.zip', 'tar.gz', 'rar');
						if(!in_array($extension, $validation_array))
						{
							$flag_check = "VALID";
						}
						else
						{
							$flag_check = "INVALID";
							return $flag_check;
						}
					}

					if($flag_check == "VALID")
					{
						if($_POST[''.$uploaded_file_info['form_field_name_hidden'].'']!='' && file_exists($uploaded_file_info['file_path'].$_POST[''.$uploaded_file_info['form_field_name_hidden'].'']))
						{
							@unlink($uploaded_file_info['file_path'].$_POST[''.$uploaded_file_info['form_field_name_hidden'].'']);
						}

						$random_number = create_password(5);
						$file_name = $random_number."_".$_FILES[''.$uploaded_file_info['form_field_name'].'']['name'];

						move_uploaded_file($_FILES[''.$uploaded_file_info['form_field_name'].'']['tmp_name'], $uploaded_file_info['file_path'].$file_name);
					}

					$field_data.= $uploaded_file_info['form_field_name'].", ";
					$values_data_insert.= ":".$uploaded_file_info['form_field_name'].", ";
					$values_data_update.= $uploaded_file_info['form_field_name']."=:".$uploaded_file_info['form_field_name'].", ";
					$execute_data[''.$uploaded_file_info['form_field_name'].''] = $file_name;
				}
			}
			else
			{
				if($_FILES[''.$uploaded_file_info['form_field_name'].'']['name']!='')
				{
					$position_of_dot = strrpos($uploaded_file_info['form_field_name']['name'],'.');
					$extension = substr($uploaded_file_info['form_field_name']['name'], $position_of_dot+1);

					if($uploaded_file_info['file_type'] == 'image')
					{
						$validation_array = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
						if(in_array(strtolower($extension), $validation_array))
						{
							$flag_check = "VALID";
						}
						else
						{
							$flag_check = "INVALID";
							return $flag_check;
						}
					}
					if($uploaded_file_info['file_type'] == 'file')
					{
						$validation_array = array('exc', 'dmf', '.zip', 'tar.gz', 'rar', 'jpg', 'jpeg', 'png', 'gif', 'bmp');
						if(!in_array(strtolower($extension), $validation_array))
						{
							$flag_check = "VALID";
						}
						else
						{
							$flag_check = "INVALID";
							return $flag_check;
						}
					}
					if($uploaded_file_info['file_type'] == 'all')
					{
						$validation_array = array('exc', 'dmf', '.zip', 'tar.gz', 'rar');
						if(!in_array($extension, $validation_array))
						{
							$flag_check = "VALID";
						}
						else
						{
							$flag_check = "INVALID";
							return $flag_check;
						}
					}

					if($flag_check == "VALID")
					{
						$random_number = create_password(5);
						$file_name = $random_number."_".$_FILES[''.$uploaded_file_info['form_field_name'].'']['name'];

						move_uploaded_file($_FILES[''.$uploaded_file_info['form_field_name'].'']['tmp_name'], $uploaded_file_info['file_path'].$file_name);
					}

					$field_data.= $uploaded_file_info['form_field_name'].", ";
					$values_data_insert.= ":".$uploaded_file_info['form_field_name'].", ";
					$values_data_update.= $uploaded_file_info['form_field_name']."=:".$uploaded_file_info['form_field_name'].", ";
					$execute_data[''.$uploaded_file_info['form_field_name'].''] = $file_name;
				}
			}
		}
	}

	$data = find_custom("SHOW COLUMNS FROM ".$table."");
	foreach($data AS $values)
	{
		array_push($db_field_array, $values['Field']);
	}

	foreach($_POST AS $key=>$value)
	{
		if(in_array($key, $db_field_array))
		{
			if($key == 'id' || $key == 'id_custom')
			{
				//DO NOTHING;
			}
			else
			{
				if($key == "password")
				{
					if($value!='')
					{
						$field_data.= $key.", ";
						$values_data_insert.= ":".$key.", ";
						$values_data_update.= $key."=:".$key.", ";
						$execute_data[''.$key.''] = hash_password(stripslashes(trim($value)));
					}
				}
				else
				{
					$field_data.= $key.", ";
					$values_data_insert.= ":".$key.", ";
					$values_data_update.= $key."=:".$key.", ";
					if(is_array($value) && count($value) > 0)
					{
						$value = implode($value);
					}
					$execute_data[''.$key.''] = stripslashes(trim($value));
				}
			}
		}
	}


	$field_data = rtrim($field_data, ', ');
	$values_data_insert = rtrim($values_data_insert, ', ');
	$values_data_update = rtrim($values_data_update, ', ');


	if(isset($_POST['id']) && $_POST['id']!='')
	{
		if(isset($_POST['id_custom']) && $_POST['id_custom']!='')
		{
			$where_clause = 'WHERE '.$_POST['id'].'='.$_POST['id_custom'].'';
		}
		else
		{
			$where_clause = 'WHERE id='.$_POST['id'].'';
		}

		if(update($table, $values_data_update, $where_clause, $execute_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		if($last_inserted_id = save($table, $field_data, $values_data_insert, $execute_data))
		{
			return $last_inserted_id;
		}
		else
		{
			return false;
		}
	}
	/*print $field_data."<br/>";
	print $values_data_insert."<br/>";
	print $values_data_update."<br/>";
	print_r($execute_data)."<br/>";
	exit;*/
}

/*
function module_data_exists_check($condition, $table)

* check if the current data already exists in database or not.
* $condition: the where condition that needs to be checked.
* $table: name of the table to which you need to validate
* return true if success or false is invalid.
*/

function module_data_exists_check($condition, $table)
{
	$where_clause = "WHERE ".$condition;

	if($check = find("first", $table, $value='id', $where_clause, array()))
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>