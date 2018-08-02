<?php
class connection{
	

	function connect($host,$user,$pass){
		$con = mysql_connect($host,$user,$pass);
		if(!$con){ die("Error : ".mysql_error());}
		return $con;
	}
	
	function Servercon1(){
		$host = "115.124.120.165";
		$user = "simm1_dbadmin";
		$pass = "Kittu@Umesh";
		$con1 = $this->connect($host,$user,$pass);
		return $con1;
	}
	function Servercon2(){
		$host = "localhost";
		$user = "root";
		$pass = "ripl";
		$con2 = $this->connect($host,$user,$pass);
		return $con2;
	}
	
	function FindStarting($table,$con,$AutoField){
		$query = "SELECT $AutoField FROM $table ORDER BY $AutoField desc LIMIT 1";
		$result = mysql_query($query,$con);
		if(!$result){ die("Error ".mysql_error()); }
		while($rec = mysql_fetch_assoc($result)){
			$id = $rec[$AutoField];
		}
		return $id;
	}
	
	function query($query,$con){
		$result = mysql_query($query,$con);
		if(!$result){ die("Error ".mysql_error()); }
		return $result;
	}
	
	function GetTableAutoID($tblname){
		switch ($tblname){
			case "tb_requests":
				return "refund_id";
				break;
			case "tb_mars_responses":
				return "balance_transfer_id";
				break;
			case "tb_user_accounts":
				return "account_id";
				break;
			case "tb_provider_accounts":
				return "request_log_id";
				break;
			default:
				die("Autoincrement Field is Not Defined");
		}
	}
	
}
	//$table = "simm_request_vmn";
	$table = urlencode(trim($_GET['tbl']));
	$limit = 50;
	
	
	$myclass = new connection;
//	$AutoField = $myclass ->GetTableAutoID($table);
	$AutoField = "id";
	
	$server1  = $myclass->Servercon1();
	$db1 = mysql_select_db("simm1_api",$server1);
	if(!$db1){ die("Error ".mysql_error()); }
	echo "server1 connected Successfully<br />";
	
	$server2  = $myclass->Servercon2();
	$db2 = mysql_select_db("api",$server2);
	if(!$db2){ die("Error ".mysql_error()); }
	echo "server2 connected Successfully<br />";
	
	$start = $myclass->FindStarting($table,$server2,$AutoField);
	
	
	echo "Starting from = ".$start."<br />";
	echo "Ending To = ".($start+$limit)."<br />";

	$query = "SELECT * FROM $table WHERE $AutoField >'$start' LIMIT $limit";
	
	$result = $myclass->query($query,$server1);
	
	if(mysql_num_rows($result) >= 1){
	$i = 1;
			while($rec = mysql_fetch_assoc($result)){
				$a = array_keys($rec);
				$record=implode("%%%%",$rec);
				$rec=str_replace("'","",$record);
				$array=explode("%%%%",$rec);
				$rec=implode("','",$array);

				$query = "INSERT INTO $table (".implode(',',$a).") VALUES ('".$rec."')";
				$myclass->query($query,$server2);	
				$i++;
			}
		$stop=0;
	}else{
		$stop =1;
	}
		
	mysql_close($server1);
	mysql_close($server2);

 ?>
 <?php if($stop==0){?>
 <input type="text" name="complete" id="complete" value="finish" readonly="readonly"/>
 <script>
	$("#complete").val("finish");
</script>
<?php }?>

 <?php if($stop==1){?>
 <input type="text" name="complete" id="complete" value="finish" readonly="readonly"/>
 <script>
	$("#complete").val("Stop Finished");
</script>
<?php }?>