<?php 
	$tblist =array('tb_requests','tb_mars_responses','tb_user_accounts','tb_provider_accounts');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Database Synchronization</title>
		<link type="text/css" href="css/dot-luv/jquery-ui-1.8.13.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);

				var myTimer=0;
				$("#start").click(function(event){	

					myTimer = setInterval(function() {						
						var msg = $("#complete").val();
						
						if(msg=="finish"){
							$("#complete").val("start");
							
							var tbl = $("#tablename").val();
							
							$.ajax({url:"webservise.php?tbl="+tbl, success:function(result){
								$("#post").html(result);
							}});
						}
						
					}, 2000);
				});
				
				$("#stop").click(function(event){	
					clearInterval(myTimer);
				});
				
			});
		</script>
		
		<style type="text/css">
			/*demo page css*/
			body{ font: 14px "Trebuchet MS", sans-serif; margin: 50px; color:#FFF;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
			.style1{
				color:#FFF;
				font:12px;
			}
			h2{ color:#000; }
		</style>	
	</head>
	<body>
		<h2>Database Synchronization(API)</h2>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Backup of Simm1</a></li>
				<li><a href="#tabs-2">Remove Old</a></li>
			</ul>
			<div id="tabs-1">
			<table>
				<tr>
					<td>Table Name</td>
					<td>
						<select name="tablename" id="tablename">
						  <option value="" select="">Please Select ................</option>
						  <?php foreach($tblist as $rec){?>
						  <option value="<?php echo $rec; ?>"><?php echo $rec; ?></option>
						  <?php }?>
						</select>
					</td>
					<td>&nbsp;</td>
					<td>
						<button id="start" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button" aria-disabled="false"><span class="ui-button-text">Start Synchronization</span></button>
						<button id="stop" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button" aria-disabled="false"><span class="ui-button-text">Stop Synchronization</span></button>
					</td>
				</tr>
			</table>
				<!--Ajax Div -->
					<div id="post" class="style1">
						<input type="text" name="complete" id="complete" value="finish" readonly="readonly"/>
					</div>
				<!--Ajax Div -->
		
			</div>
			<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>
			
		</div>
		<div align="right">
		<strong>
		<a href="index.php">Database Synchronization(Simm1)</a> | 
		<a href="web.php">Database Synchronization(API)</a>
		</strong>
		</div>
		
	</body>
	</html>