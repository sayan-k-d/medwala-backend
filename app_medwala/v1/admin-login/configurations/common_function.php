<?php
/*
=========================================================================================================================
COPYRIGHT: NEOCODERZ TECHNOLOGIES
PRODUCT NAME: TRAVEL PORTAL
PAGE NAME: CONFIG.PHP
PAGE FUNCTIONALITY: THIS FILE CONSISTS OF DEFINATIONS OF ALL FUNCTIONS THAT ARE BEEN USED THROUGHOUT THE PRODUCT.
=========================================================================================================================
*/

/*
function find()

* fetch record from database
* @param string type: Can be all / first
* @param string table: Name of the table
* @param string value: Table fields values that needs to be fetched (filed1, field2)
* @param string where_clause: Where conditions based on which data needs to be fetched (WHERE field1=:defined_value1 AND field2=:defined_value2 OR field3=:defined_value3)
* @param array execute: Consists of actual values of defined variables (array(':defined_value1'=>$_POST['POST_DATA1'], ':defined_value2'=>$_POST['POST_DATA2'],))
* @returns an array of fetched records.
* @example1: find('first', 'table_name', 'field1, field2', 'WHERE field1:=defined_value1 AND field2:=defined_value2', array(':defined_value1'=>$_POST['DATA1'], ':defined_value2'=>$_POST['DATA2'])); 
* @example2: find('all', 'table_name', 'field1, field2', 'WHERE field1:=defined_value1 AND field2:=defined_value2', array(':defined_value1'=>$_POST['DATA1'], ':defined_value2'=>$_POST['DATA2']));
*/

function find($type, $table, $value='*', $where_clause, $execute)
{
	global $db;

	if($where_clause)
	{
		   $sql = "SELECT ".$value." FROM ".$table." ".$where_clause."";
	}

	else
	{
		$sql = "SELECT ".$value." FROM ".$table;
	}
	//echo $sql;
	$prepare_sql = $db->prepare($sql);

	foreach($execute As $key=>$value)
	{
		$execute[$key] = stripslashes($value);
	}
	$prepare_sql->execute($execute);

	if($prepare_sql->errorCode() == 0)
	{
		if($type == 'first')
		{
			//fetch single record from database
			$result = $prepare_sql->fetch();
		}
		else if($type == 'all')
		{
			//fetch multiple record from database
			$result = $prepare_sql->fetchAll();
		}
		return $result;
	} 
	else
	{
		$errors = $prepare_sql->errorInfo();
		echo '<pre>';
		print_r($errors[2]);
		echo '</pre>';
		die();
	}
	
}

/*
function find_custom()

* fetch record from database
* @param string string: The entire Sql Statement
*/

function find_custom($string)
{
	global $db;

	$sql = $string;

	$prepare_sql = $db->prepare($sql);

	$execute = array();

	foreach($execute As $key=>$value)
	{
		$execute[$key] = stripslashes($value);
	}
	$prepare_sql->execute($execute);

	if($prepare_sql->errorCode() == 0)
	{
		$result = $prepare_sql->fetchAll();
		return $result;
	} 
	else
	{
		$errors = $prepare_sql->errorInfo();
		echo '<pre>';
		print_r($errors[2]);
		echo '</pre>';
		die();
	}
	
}

/*
function save()

* insert record into database
* @param string table: Name of the table
* @param string fields: Lists of fields name of the corresponding database table within which data needs to be added (field1, field2)
* @param string values: Lists of defined values variables that will be used in ececute array reflect corresponding table fields (:defined_value1, :defined_value2)
* @param array execute: Lists of defined values variables along with the actual values that needs to be added within the database tables (array(':defined_value1'=>$_POST['POST_DATA1'], ':defined_value2'=>$_POST['POST_DATA2']))
* @ returns last inserted id.
* @ example: save('table_name', 'fields1, fields2', ':defined_value1, :defined_value2', array(':defined_value1'=>$_POST['POST_DATA1'], ':defined_value2'=>$_POST['POST_DATA2']))
*/

function save($table, $fields, $values, $execute)
{
	global $db;
	$result = false;
	 $sql = "INSERT INTO ".$table." (".$fields.") VALUES (".$values.")";
	$prepare_sql = $db->prepare($sql);
	foreach($execute As $key=>$value)
	{
		$execute[$key] = stripslashes($value);
	}
	$prepare_sql->execute($execute);
	$result = $db->lastInsertId();
	return $result;
}

/*
function update()

* update record into database
* @param string table: Name of the table
* @param string set fields: Database tables fields names that needs to be updated ('fields1=:defined_value1, fields2=:defined_value2')
* @param string where_clause: Where condition based on which the database table will be updated ('WHERE fields1=:defined_value1 AND WHERE fields2=:defined_value2')
* @param array execute:  Lists of defined values variables along with the actual values that needs to be updated within the database tables (array(':defined_value1'=>$_POST['POST_DATA1'], ':defined_value2'=>$_POST['POST_DATA2']))
* @return true or false
* @ example: update('table_name', 'fields1=:defined_value1, fields2=:defined_value2', 'WHERE fields1=:defined_value1 AND fields2=:defined_value2', array(':defined_value1'=>$_POST['POST_DATA1'], ':defined_value2'=>$_POST['POST_DATA2']))
*/

function update($table, $set_value, $where_clause, $execute)
{
	global $db;

	$sql = "UPDATE ".$table." SET ".$set_value." ".$where_clause."";
	
	$prepare_sql = $db->prepare($sql);
	foreach($execute As $key=>$value){
		$execute[$key] = stripslashes($value);
		//echo '<pre>';
		//print_r($execute);
		//echo '</pre>';
	}
	//exit;
	$prepare_sql->execute($execute);
	
	return true;
}

/*
function delete()

* delete record from database
* @param string table: Name of the table
* @param string where_clause: Where condition based on which the database table will be updated ('WHERE fields1=:defined_value1 AND WHERE fields2=:defined_value2')
* @param array execute:  Lists of defined values variables along with the actual values that needs to be updated within the database tables (array(':defined_value1'=>$_POST['POST_DATA1'], ':defined_value2'=>$_POST['POST_DATA2']))
* @return true or false
* @ example: delete('table_name', 'WHERE fields1=:defined_value1', array(':defined_value1'=>$_POST['POST_DATA1']))
*/

function delete($table, $where_clause, $execute)
{
	global $db;

	$sql = "DELETE FROM ".$table." ".$where_clause."";
	$prepare_sql = $db->prepare($sql);
	$prepare_sql->execute($execute);

	if($prepare_sql->errorCode() == 0) 
	{
		return true;
	} 
	else 
	{
		$errors = $prepare_sql->errorInfo();
		echo '<pre>';
		print_r($errors[2]);
		echo '</pre>';
		die();
	}
}


/*
function Send_HTML_Mail()

* send HTML or text email without SMTP validation.
* @param string mail_To: Email address which which email needs to be sent.
* @param string mail_From: Email address from which email needs to be sent.
* @param string mail_CC: Enter email address that you wish to send a cc copy (optional).
* @param string mail_subject: Email subject line.
* @param string mail_Body: Email content either in HTML format or simple text format.
* @returns true or false.
*/

function Send_HTML_Mail($mail_To, $mail_From, $mail_CC, $mail_subject, $mail_Body)
{
	$mail_Headers  = "MIME-Version: 1.0\r\n";
	$mail_Headers .= "Content-type: text/html; charset=utf-8\r\n";		
	$mail_Headers .= "From: ${mail_From}\r\n";

	if($mail_CC != '')
	{
		$mail_Headers .= "Cc: ${mail_CC}\r\n";
	}

	if(mail($mail_To, $mail_subject, $mail_Body, $mail_Headers))
	{			
		return true;
	}
	else
	{        	
		return false;
	}
}

/*
function Send_SMTP_Mail()

* send HTML or text email without SMTP validation.
* @param string mail_To: Email address which which email needs to be sent.
* @param string mail_From: Email address from which email needs to be sent.
* @param string mail_CC: Enter email address that you wish to send a cc copy (optional).
* @param string mail_subject: Email subject line.
* @param string mail_Body: Email content either in HTML format or simple text format.
* @returns true or false.
*/

function Send_SMTP_Mail($mail_To, $mail_From, $mail_CC, $mail_subject, $mail_Body)
{
	include_once ("class.phpmailer.php");
	include_once ("class.smtp.php");

	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->Host = "localhost";
	$mail->SMTPAuth = true;
	$mail->Username = "";
	$mail->Password = "";
	$mail->From = "";
	$mail->FromName = "";
	$mail->AddAddress($mail_To, ""); 
	$mail->IsHTML(true);  // set email format to HTML
	$mail->Subject = $mail_subject;
	$mail->Body = $mail_Body;
	$mail->Send();
}

/*
function create_password()

* create random number with maximum length of 10.
* @param length: Can be any interger value starting from 1 to 10.
* @returns randon generated string with specified length.
*/

function create_password($length=10)
{
   $phrase = "";
   $chars = array (
				  "1","2","3","4","5","6","7","8","9","0",
				  "a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
				  "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
				  "u","U","v","V","w","W","x","X","y","Y","z","Z"
				  );

   $count = count ($chars) - 1;
   srand ((double) microtime() * 1234567);
   for ($i = 0; $i < $length; $i++)
	  $phrase .= $chars[rand (0, $count)];
   return $phrase;
}

/*
function cleantohtml()

* Restores the added slashes (ie.: " I\'m John " for security in output, and escapes them in htmlentities(ie.:  &quot; etc.)
  It preserves any <html> tags in that they are encoded aswell (like &lt;html&gt;)
  As an extra security, if people would try to inject tags that would become tags after stripping away bad characters
  we do still strip tags but only after htmlentities, so any genuine code examples will stay
* @param form: form field value.
* @Use: For input fields that may contain html, like a textarea
* @returns formatted form filed value.
*/

function cleantohtml($s)
{
	return strip_tags(htmlentities(trim(stripslashes($s))), ENT_NOQUOTES);
}

/*
function stripcleantohtml()

* Restores the added slashes (ie.: " I\'m John " for security in output, and escapes them in htmlentities(ie.:  &quot; etc.)
  It preserves any <html> tags in that they are encoded aswell (like &lt;html&gt;)
  As an extra security, if people would try to inject tags that would become tags after stripping away bad characters
  we do still strip tags but only after htmlentities, so any genuine code examples will stay
* @param form: form field value.
* @Use: For input fields that may contain html, like a textarea
* @returns formatted form filed value.
*/

function stripcleantohtml($s)
{
	return htmlentities(trim(strip_tags(stripslashes($s))), ENT_NOQUOTES, "UTF-8");
}


/*
function file_download()

* provide option to download any files.
* @param download_path: Path of the files that needs to be downloaded.
* @returns downloaded file.
*/

function file_download($download_path)
{
	$path = $download_path;
	$file = $path;
	$filename = basename($file);
	$file_extension = strtolower(substr(strrchr($filename,"."),1));
	$download_size = filesize($file);
	switch( $file_extension )
	{
	  case "pdf": $ctype="application/pdf"; break;
	  case "csv": $ctype="application/csv"; break;
	  case "exe": $ctype="application/octet-stream"; break;
	  case "zip": $ctype="application/zip"; break;
	  case "doc": $ctype="application/msword"; break;
	  case "docx": $ctype="application/msword"; break;
	  case "xls": $ctype="application/vnd.ms-excel"; break;
	  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	  case "gif": $ctype="image/gif"; break;
	  case "png": $ctype="image/png"; break;
	  case "jpeg":
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/force-download";
	}
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);

	//Use the switch-generated Content-Type
	header("Content-Type: $ctype");
	header('Content-Transfer-Encoding: Binary');

	//Force the download
	header("Accept-Ranges: bytes");
	header("Content-Length: $download_size");

	header('Content-Disposition: attachment; filename="'.$filename.'";');
	readfile($file);
}


/*
function read_all_files()

* provide option to read all files and dirctory name available within a specified path.
* @param root: Path of the root directory.
* @returns array of entire directory structure.
*/

function read_all_files($root = '.')
{
	$files  = array();
	$directories  = array();
	$last_letter  = $root[strlen($root)-1];
	$root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;

	$directories[]  = $root;

	while (sizeof($directories)) 
	{
		$dir  = array_pop($directories);
		if ($handle = opendir($dir)) 
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file == '.' || $file == '..') 
				{
					continue;
				}
				$file  = $dir.$file;
				if (is_dir($file)) 
				{
					$directory_path = $file.DIRECTORY_SEPARATOR;
					array_push($directories, $directory_path);
					$files[]  = $directory_path;
				}
				elseif (is_file($file)) 
				{
					$files[]  = $file;
				}
			}
			closedir($handle);
		}
	}
	return $files;
}


/*
function xcopy()

* Copy files and directories from source to destination
* @param source: Path of the source directory / files.
* @param dest: Path of the destination directory / files.
* @param permissions: access permission of copied directory.
* @returns array of entire directory structure.
*/

function xcopy($source, $dest, $permissions = 0777)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest, $permissions);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        xcopy("$source/$entry", "$dest/$entry", $permissions);
    }

    // Clean up
    $dir->close();
    return true;
}


/*
function scan_dir()

* Scan directory provided in $path and provide the lsits of files availabel within that directory
* @param $path: Path of the source directory / files.
* @returns array of total_files, file_size and file_names.
*/

function scan_dir($path){
    $ite=new RecursiveDirectoryIterator($path);

    $bytestotal=0;
    $nbfiles=0;
	$files = array();
    foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
        
		if($filename == '.' || $filename == '..' || is_dir($filename))
		{
			//DO NOTHING
		}
		else
		{
			$filesize=$cur->getSize();
			$bytestotal+=$filesize;
			$nbfiles++;
			$files[] = $filename;
		}
    }

    $bytestotal=number_format($bytestotal);

    return array('total_files'=>$nbfiles,'total_size'=>$bytestotal,'files'=>$files);
}

/*
function weeks_in_month()

* This function used to get the number of weeks in a month for a specific year and month
* @param $year: current year
* @param $month: current month
* @start_day_of_week: set it to 1
* @returns count number of weeks.
*/

function weeks_in_month($year, $month, $start_day_of_week)
{
	// Total number of days in the given month.
	$num_of_days = date("t", mktime(0,0,0,$month,1,$year));

	// Count the number of times it hits $start_day_of_week.
	$num_of_weeks = 0;
	for($i=1; $i<=$num_of_days; $i++)
	{
		$day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
		if($day_of_week==$start_day_of_week)
		$num_of_weeks++;
	}
	return $num_of_weeks;
}

/*
function createDateRangeArray($strDateFrom, $strDateTo)

* This function used to get the entire date range for a specified start date and end date
* @param $strDateFrom: Start date from
* @param $strDateTo: End date to
* @returns count lists of days in an array format.
*/

function createDateRangeArray($strDateFrom, $strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d-D',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d-D',$iDateFrom));
        }
    }
    return $aryRange;
}

/*
function current_page()

* This function used to get the name of the current page or last seo page name that you are current viewing
* @returns name of the page or seo name.
*/

function current_page()
{
	$split_page_path = explode('/', $_SERVER['PHP_SELF']);
	$page_name = end($split_page_path);
	return $page_name;
}


/*
function generateFormToken()

* generate a token from an unique value
* @param form: name of the form.
* @returns random generated security token
*/

function generateFormToken($form) 
{
	// generate a token from an unique value
	$token = md5(uniqid(microtime(), true));  
	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	$_SESSION[$form.'_token'] = $token; 
	return $token;
}

/*
function verifyFormToken()

* check with the submitted token through form submission
* @param form: name of the form.
* @returns true if match found or false in not found.
*/

function verifyFormToken($form) 
{
    // check if a session is started and a token is transmitted, if not return an error
	if(!isset($_SESSION[$form.'_token'])) 
	{ 
		return false;
    }
	
	// check if the form is sent with token in it
	if(!isset($_POST['token'])) 
	{
		return false;
    }
	
	// compare the tokens against each other if they are still the same
	if ($_SESSION[$form.'_token'] !== $_POST['token']) 
	{
		return false;
    }
	return true;
}

/*
function shorten_string($string, $wordsreturned)

* this function cut the scring to certain length provided.
* @param string: raw string data provided.
* @param wordsreturned: number of work needs to be rerurned.
* @returns cut string.
*/
function shorten_string($string, $wordsreturned)
{
  $retval = $string;
  $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
  $string = str_replace("\n", " ", $string);
  $array = explode(" ", $string);
  if (count($array)<=$wordsreturned)
  {
    $retval = $string;
  }
  else
  {
    array_splice($array, $wordsreturned);
    $retval = implode(" ", $array)." ...";
  }
  return $retval;
}

/*
function isValidLength($text , $length)

* this function check the provided string length with provided length
* @param text: raw string data provided.
* @param length: length needs to be checked.
* @returns if match found retun true otehrwise return false.
*/
function isValidLength($text , $length){

   $text  = explode(" " , $text );
   if(count($text) > $length)
          return false;
   else
          return true;
}

/*
function hash_password($password)

* this function generate the cript() version of the provided password. 
* @param password: raw password entered by the user.
* @returns if match found retun true otehrwise return false.
*/
function hash_password($password)
{
   $hashed_password = crypt($password, SECURITY_SALT);
   return $hashed_password;
}

/*
function post_form_status($from_data, $data = null, $type)

* this function will check the posted form data or database driven data and will show in value fields accordingly. 
* @param from_data: posted data or database driven data.
* @param data: data to which the posted form data to database driven data needs to be checked. It can be null as well
* @param type: it signifies what type of form field it is.
* @returns data if found or corresponding tag for checkbox and drop-down otherwise return false.
*/
function post_form_status($from_data, $data = null, $type)
{
	if($type == 'text' || $type == 'text-area')
	{
		if(isset($from_data) && $from_data!='')
		{
			return $from_data;
		}
	}
	else if($type == 'dropdown')
	{
		if(isset($from_data) && $from_data == $data)
		{
			return "selected=selected";
		}
	}
	else if($type == 'checkbox' || $type == 'radio')
	{
		if(isset($from_data) && $from_data == $data)
		{
			return "checked";
		}
	}
	else
	{
		return false;
	}
}

/*
function unlink_files($file_name, $file_path)

* this function will delete the file within the specified path. 
* @param file_name: name of the file that needs to be deleted.
* @param file_path: path of teh file that needs to be deleted.
* @returns true if deleted otehrwise false.
*/
function unlink_files($file_name, $file_path)
{
	if($file_name!='' && file_exists($file_path.$file_name))
	{
		if(unlink($file_path.$file_name))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}




function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
}



//PHP EMAILER FUNCTION START
     function smtpmailer($to, $from, $from_name, $subject, $body)
    {
       
        $from='no-reply@grihoudyog.a2hosted.com';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = 'mail.grihoudyog.a2hosted.com';
        $mail->Port = 465;  
        $mail->Username = 'no-reply@grihoudyog.a2hosted.com';
        $mail->Password = 'prince@9038';   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
        $mail->IsHTML(true);
        $mail->From="no-reply@grihoudyog.a2hosted.com";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error ="Please try Later, Error Occured while Processing...";
            return $error; 
        }
        else 
        {
            $error = "Thanks You !! Your email is sent.";  
            return $error;
        }
    }
    //PHP EMAILER FUNCTION END
?>