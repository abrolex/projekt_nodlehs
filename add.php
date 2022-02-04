<?php
require($_SERVER['DOCUMENT_ROOT'].'/include/config.inc.php');

$output = '<div class="container">';

$sql = mysqli_connect($app_sqlhost,$app_sqluser,$app_sqlpasswd,$app_sqldb);

if(!$sql)
{
	$output .= '<div class="panel dark">';
	$output .= '<p>Es konnte keine Datenbankverbindung hergestellt werden.</p>';
	$output .= '</div></div>';
}
else
{
	if(!empty($_GET))
	{
		if(empty($_GET['category']))
		{
			$output .= '<div class="panel dark">';
			$output .= '<p>Es wurde keine Kategorie gesendet.</p>';
			$output .= '</div></div>';
		}
		else
		{
			if(preg_match('/[^a-z]/',$_GET['category']) == 0)
			{
				$allowed_category = array('asset','vendor','model','type');
				
				if(in_array($_GET['category'],$allowed_category))
				{
					$output .= '<div class="section">';
					$output .= '<ul>';
					$output .= '<li><button class="btn-default dark" type="submit"><i class="fas fa-plus"></i></button></li>';
					$output .= '<li><form action="search.php" method"get"><input type="hidden" name="category" value="'.$_GET['category'].'"/><input class="ipt-stretch" name="search" placeholder="Suchen"><button class="btn-default dark" type="submit"><i class="fas fa-search"></i></button></form></li>';
					$output .= '</ul>';
					$output .= '</div>';
					
					switch($_GET['category'])
					{
						case $allowed_category[0]:
							
							$showform = 1;
							
							$output .= '<h1>Asset hinzuf&uuml;gen</h1>';
							$output .= '</div>';
							
							if(!empty($_GET['send']))
							{
								if(empty($_GET['type_id']) || empty($_GET['vendor_id']) || empty($_GET['model_id']) || empty($_GET['asset_serial']))
								{
									$output .= '<div class="top-info dark">';
									$output .= '<ul>';
									$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
									$output .= '<li><div class="container">Es wurden nicht alle Daten gesendet.</div></li>';
									$output .= '</ul>';
									$output .= '</div>';
								}
								else
								{
									if(preg_match('/[^0-9]/',$_GET['type_id']) == 0)
									{
										if(preg_match('/[^0-9]/',$_GET['vendor_id']) == 0)
										{
											if(preg_match('/[^0-9]/',$_GET['model_id']) == 0)
											{
												if(preg_match('/[^a-zA-Z0-9\-\.]/',$_GET['asset_serial']) == 0)
												{
													$query = sprintf("
													INSERT INTO
													asset
													(asset_type_id,asset_vendor_id,asset_model_id,asset_serial)
													VALUES
													('%s','%s','%s','%s');",
													$sql->real_escape_string($_GET['type_id']),
													$sql->real_escape_string($_GET['vendor_id']),
													$sql->real_escape_string($_GET['model_id']),
													$sql->real_escape_string($_GET['asset_serial']));
													
													$sql->query($query);
										
													if($sql->affected_rows == 1)
													{
														$output .= '<div class="top-info dark">';
														$output .= '<ul>';
														$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
														$output .= '<li><div class="container">Das Asset <strong>'.$_GET['asset_serial'].'</strong> wurde hinzugef&uuml;gt.</div></li>';
														$output .= '</ul>';
														$output .= '</div>';
													}
													else
													{
														$output .= '<div class="top-info dark">';
														$output .= '<ul>';
														$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
														$output .= '<li><div class="container">Das Asset <strong>'.$_GET['asset_serial'].'</strong> ist bereits vorhanden.</div></li>';
														$output .= '</ul>';
														$output .= '</div>';
													}
												}
												else
												{
													$output .= '<div class="top-info dark">';
													$output .= '<ul>';
													$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
													$output .= '<li><div class="container">Verwenden Sie nur folgende Zeichen: a-z, A-Z, 0-9, -.</div></li>';
													$output .= '</ul>';
													$output .= '</div>';
												}
											}
											else
											{
												$output .= '<div class="top-info dark">';
												$output .= '<ul>';
												$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
												$output .= '<li><div class="container">Die ModellId besteht nur aus Zahlen.</div></li>';
												$output .= '</ul>';
												$output .= '</div>';
											}
										}
										else
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Die HerstellerId besteht nur aus Zahlen.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
									}
									else
									{
										$output .= '<div class="top-info dark">';
										$output .= '<ul>';
										$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
										$output .= '<li><div class="container">Die TypId besteht nur aus Zahlen.</div></li>';
										$output .= '</ul>';
										$output .= '</div>';
									}
								}
							}
							
							if($showform)
							{
								$output .= '<form action="add.php" method="get">';
								$output .= '<input type="hidden" name="category" value="'.$_GET['category'].'"/>';
								$output .= '<ul>';
								$output .= '<li class="col-l4">';
								$output .= '<div class="margin">';
								$output .= '<select class="ipt-default" name="type_id">';
								$output .= '<option value="">Typ w&auml;hlen</option>';
								
								$query = "
								SELECT type_id,type_name
								FROM type";
								
								$result = $sql->query($query);
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									$output .= '<option value="'.$row['type_id'].'">'.$row['type_name'].'</option>';
								}
								
								$output .= '</select>';
								$output .= '</div>';
								$output .= '</li>';
								$output .= '<li class="col-l4">';
								$output .= '<div class="margin">';
								$output .= '<select class="ipt-default" name="vendor_id">';
								$output .= '<option value="">Hersteller w&auml;hlen</option>';
								
								$query = "
								SELECT vendor_id,vendor_name
								FROM vendor";
								
								$result = $sql->query($query);
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									$output .= '<option value="'.$row['vendor_id'].'">'.$row['vendor_name'].'</option>';
								}
								
								$output .= '</select>';
								$output .= '</div>';
								$output .= '</li>';
								$output .= '<li class="col-l4">';
								$output .= '<div class="margin">';
								$output .= '<select class="ipt-default" name="model_id">';
								$output .= '<option value="">Modell w&auml;hlen</option>';
								
								$query = "
								SELECT model_id,model_name
								FROM model";
								
								$result = $sql->query($query);
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									$output .= '<option value="'.$row['model_id'].'">'.$row['model_name'].'</option>';
								}
								
								$output .= '</select>';
								$output .= '</div>';
								$output .= '</li>';
								$output .= '</ul>';
								$output .= '<div class="container">';
								$output .= '<ul>';
								$output .= '<li class="col-l10"><input class="ipt-default" name="asset_serial" placeholder="Seriennummer"/></li>';
								$output .= '<li class="col-l2"><button class="block btn-default dark"><i class="fas fa-arrow-right"></i></button></li>';
								$output .= '</ul>';
								$output .= '</div>';
								$output .= '<input type="hidden" name="send" value="1"/>';
								$output .= '</form>';
							}
							
							break;
						
						case $allowed_category[1]:
						
							$showform = 1;
							
							$output .= '<h1>Hersteller hinzuf&uuml;gen</h1>';
							$output .= '</div>';
							$output .= '<div class="container">';
							
							if(!empty($_GET['send']))
							{
								if(empty($_GET['vendor_name']))
								{
									$output .= '<div class="top-info dark">';
									$output .= '<ul>';
									$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
									$output .= '<li><div class="container">Es wurde kein Herstellername gesendet.</div></li>';
									$output .= '</ul>';
									$output .= '</div>';
								}
								else
								{
									if(preg_match('/[^a-zA-ZöäüÖÄÜß0-9\-\s]/',$_GET['vendor_name']) == 0)
									{
										$query = sprintf("
										INSERT INTO
										vendor
										(vendor_name)
										VALUES
										('%s');",
										$sql->real_escape_string($_GET['vendor_name']));
										
										$sql->query($query);
										
										if($sql->affected_rows == 1)
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Der Hersteller <strong>'.$_GET['vendor_name'].'</strong> wurde hinzugef&uuml;gt.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
										else
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Der Hersteller <strong>'.$_GET['vendor_name'].'</strong> ist bereits vorhanden.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
									}
									else
									{
										$output .= '<div class="top-info dark">';
										$output .= '<ul>';
										$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
										$output .= '<li><div class="container">Verwenden Sie nur folgende Zeichen: a-z, A-Z, öäüÖÄÜß, 0-9, -</div></li>';
										$output .= '</ul>';
										$output .= '</div>';
									}
								}
							}
							
							if($showform)
							{
								$output .= '<form action="add.php" method="get">';
								$output .= '<p><input type="hidden" name="category" value="'.$_GET['category'].'"/></p>';
								$output .= '<ul>';
								$output .= '<li class="col-l10"><input class="ipt-default" type="text" name="vendor_name" placeholder="Hersteller"/></li>';
								$output .= '<li class="col-l2"><button class="block btn-default dark" type="submit"><i class="fas fa-arrow-right"></i></button></li>';
								$output .= '</ul>';
								$output .= '<p><input type="hidden" name="send" value="1"/></p>';
								$output .= '</form>';
							}
							
							$output .= '</div>';
							
							break;
							
						case $allowed_category[2]:
						
							$showform = 1;
							
							$output .= '<h1>Modell hinzuf&uuml;gen</h1>';
							$output .= '</div>';
							$output .= '<div class="container">';
							
							if(!empty($_GET['send']))
							{
								if(empty($_GET['model_name']))
								{
									$output .= '<div class="top-info dark">';
									$output .= '<ul>';
									$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
									$output .= '<li><div class="container">Es wurde kein Modellname gesendet.</div></li>';
									$output .= '</ul>';
									$output .= '</div>';
								}
								else
								{
									if(preg_match('/[^a-zA-ZöäüÖÄÜß0-9\-\s]/',$_GET['model_name']) == 0)
									{
										$query = sprintf("
										INSERT INTO
										model
										(model_name)
										VALUES
										('%s');",
										$sql->real_escape_string($_GET['model_name']));
										
										$sql->query($query);
										
										if($sql->affected_rows == 1)
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Das Modell <strong>'.$_GET['model_name'].'</strong> wurde hinzugef&uuml;gt.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
										else
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Das Modell <strong>'.$_GET['model_name'].'</strong> ist bereits vorhanden.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
									}
									else
									{
										$output .= '<div class="top-info dark">';
										$output .= '<ul>';
										$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
										$output .= '<li><div class="container">Verwenden Sie nur folgende Zeichen: a-z, A-Z, öäüÖÄÜß, 0-9, -</div></li>';
										$output .= '</ul>';
										$output .= '</div>';
									}
								}
							}
							
							if($showform)
							{
								$output .= '<form action="add.php" method="get">';
								$output .= '<p><input type="hidden" name="category" value="'.$_GET['category'].'"/></p>';
								$output .= '<ul>';
								$output .= '<li class="col-l10"><input class="ipt-default" type="text" name="model_name" placeholder="Modell"/></li>';
								$output .= '<li class="col-l2"><button class="block btn-default dark" type="submit"><i class="fas fa-arrow-right"></i></button></li>';
								$output .= '</ul>';
								$output .= '<p><input type="hidden" name="send" value="1"/></p>';
								$output .= '</form>';
							}
							
							$output .= '</div>';
							
							break;
						
						case $allowed_category[3]:
						
							$showform = 1;
							
							$output .= '<h1>Typ hinzuf&uuml;gen</h1>';
							$output .= '</div>';
							$output .= '<div class="container">';
							
							if(!empty($_GET['send']))
							{
								if(empty($_GET['type_name']))
								{
									$output .= '<div class="top-info dark">';
									$output .= '<ul>';
									$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
									$output .= '<li><div class="container">Es wurde kein Typ gesendet.</div></li>';
									$output .= '</ul>';
									$output .= '</div>';
								}
								else
								{
									if(preg_match('/[^a-zA-ZöäüÖÄÜß0-9\-\s]/',$_GET['type_name']) == 0)
									{
										$query = sprintf("
										INSERT INTO
										type
										(type_name)
										VALUES
										('%s');",
										$sql->real_escape_string($_GET['type_name']));
										
										$sql->query($query);
										
										if($sql->affected_rows == 1)
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Der Typ <strong>'.$_GET['type_name'].' </strong>wurde hinzugef&uuml;gt.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
										else
										{
											$output .= '<div class="top-info dark">';
											$output .= '<ul>';
											$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
											$output .= '<li><div class="container">Der Typ <strong>'.$_GET['type_name'].' </strong> ist bereits vorhanden.</div></li>';
											$output .= '</ul>';
											$output .= '</div>';
										}
									}
									else
									{
										$output .= '<div class="top-info dark">';
										$output .= '<ul>';
										$output .= '<li><button class="btn-default light-blue"><i class="fas fa-times"></i></button></li>';
										$output .= '<li><div class="container">Verwenden Sie nur folgende Zeichen: a-z, A-Z, öäüÖÄÜß, 0-9, -</div></li>';
										$output .= '</ul>';
										$output .= '</div>';
									}
								}
							}
							
							if($showform)
							{
								$output .= '<form action="add.php" method="get">';
								$output .= '<p><input type="hidden" name="category" value="'.$_GET['category'].'"/></p>';
								$output .= '<ul>';
								$output .= '<li class="col-l10"><input class="ipt-default" type="text" name="type_name" placeholder="Typ"/></li>';
								$output .= '<li class="col-l2"><button class="block btn-default dark" type="submit"><i class="fas fa-arrow-right"></i></button></li>';
								$output .= '</ul>';
								$output .= '<p><input type="hidden" name="send" value="1"/></p>';
								$output .= '</form>';
							}
							
							$output .= '</div>';
							
							break;
					}
				}
				else
				{
					$output .= '<div class="panel dark">';
					$output .= '<p>Die gesendete Kategorie kann nicht bearbeitet werden.</p>';
					$output .= '</div></div>';
				}
			}
			else
			{
				$output .= '<div class="panel dark">';
				$output .= '<p>Die gesendete Kategorie kann nicht bearbeitet werden.</p>';
				$output .= '</div></div>';
			}
		}
	}
	else
	{
		$output .= '<div class="panel dark">';
		$output .= '<p>Es wurden keine Daten gesendet.</p>';
		$output .= '</div></div>';
	}
}
?>		
<!DOCTYPE HTML>
<html lang="de">
	<head>
		<title>Sheldon #List</title>
		<meta charset="UTF-8"/>
		<meta name="author" content="FrogCode"/>
		<meta name="expires" content="0"/>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="/css/main.css"/>
		<script type="text/javascript" src="/js/main.js"></script>
		<script type="text/javascript" src="https://kit.fontawesome.com/7b695be7d9.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<nav class="dark">
			<ul>
				<li><p><a class="xlarge" href="index.php">Sheldon</a></p></li>
				<li><p><a href="list.php?category=asset" class="block btn-default light-blue">Assets</a></p></li>
				<li><p><a href="list.php?category=vendor" class="block btn-default light-blue">Hersteller</a></p></li>
				<li><p><a href="list.php?category=model" class="block btn-default light-blue">Modelle</a></p></li>
				<li><p><a href="list.php?category=type" class="block btn-default light-blue">Typen</a></p></li>
			</ul>
		</nav>
		<main>
		<?php
		if(!empty($output))
		{
			echo $output;
		}
		?>
		</main>
	</body>
</html>