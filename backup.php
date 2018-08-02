<?php
class connection{
	

	function connect($host,$user,$pass){
		$con = mysql_connect($host,$user,$pass);
		if(!$con){ die("Error : ".mysql_error());}
		return $con;
	}
	
	function Servercon1(){
		$host = "localhost";
		$user = "root";
		$pass = "";
		$con1 = $this->connect($host,$user,$pass);
		return $con1;
	}
	function Servercon2(){
		$host = "localhost";
		$user = "root";
		$pass = "";
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
			case "simm_balance_transfer_dvd":
				return "balance_transfer_id";
				break;
			case "simm_recharge_transaction_dvd":
				return "recharge_transaction_id";
				break;
			case "simm_api_response_dvd":
				return "api_response_id";
				break;
			case "allhits_dvd":
				 return "hit_id";
				 break;
			case "all_hits_new_dvd":
                 return "Sno";
                 break;				 
			case "simm_balance_transfer_msg_dvd":
				return "balance_transfer_msg_id";
				break;
			case "simm_request_vmn_dvd":
				return "request_vmn_id";
				break;
			case "simm_payment_table_dvd":
				return "payment_id";
                break;				
			case "simm_refund_dvd":
				return "refund_srno";
				break;
			case "simm_adminlog_dvd":
				return "adminlog_id";
				break;
			case "simm_hreporting_dvd":
				return "hreporting_id";
				break;	
			case "simm_temp_table_dvd":
				return "id";
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
	$AutoField = $myclass ->GetTableAutoID($table);
	
	$server1  = $myclass->Servercon1();
	$db1 = mysql_select_db("simm1_dbretailer",$server1);
	if(!$db1){ die("Error ".mysql_error()); }
	echo "server1 connected Successfully<br />";
	
	$server2  = $myclass->Servercon2();
	$db2 = mysql_select_db("phase_2",$server2);
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