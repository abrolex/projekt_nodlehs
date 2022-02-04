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
					$output .= '<li><form action="add.php" method="get"><input type="hidden" name="category" value="'.$_GET['category'].'"/><button class="btn-default dark" type="submit"><i class="fas fa-plus"></i></button></form></li> ';
					$output .= '<li><form action="search.php" method"get"><input type="hidden" name="category" value="'.$_GET['category'].'"/><input class="ipt-stretch" name="search" placeholder="Suchen"><button class="btn-default dark" type="submit"><i class="fas fa-search"></i></button></form></li>';
					$output .= '</ul>';
					$output .= '</div>';
					
					switch($_GET['category'])
					{
						case $allowed_category[0]:
							
							$query = "
							SELECT asset_id,type_name,vendor_name,model_name,asset_serial
							FROM asset
							INNER JOIN type ON type_id = asset_type_id
							INNER JOIN vendor ON vendor_id = asset_vendor_id
							INNER JOIN model ON model_id = asset_model_id";
							
							$result = $sql->query($query);
					
							$amount_gs = mysqli_num_rows($result);
					
							if($amount_gs > 0)
							{
								$i = 0;
								
								$output .= '<h1>Assets ( '.$amount_gs.' )</h1>';
								$output .= '</div>';
								$output .= '<ul>';
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									if($i == 2)
									{
										$output .= '</ul>';
										$output .= '<ul>';
										
										$i = 0;
									}
									
									$output .= '<li class="col-l6">';
									$output .= '<div class="margin container dark">';
									$output .= '<p>'.$row['type_name'].' '.$row['vendor_name'].' '.$row['model_name'].'</p>';
									$output .= '<p>'.$row['asset_serial'].'</p>';
									$output .= '</div>';
									$output .= '</li>';
									
									$i++;
								}
								
								$output .= '</ul>';
							}
							else
							{
								$output .= '<div class="panel light-marine">';
								$output .= '<p>Es wurden keine Eintr&auml;ge gefunden.</p>';
								$output .= '</div></div>';
							}
							
							break;
						
						case $allowed_category[1]:
						
							$query = "
							SELECT vendor_id,vendor_name
							FROM vendor";
							
							$result = $sql->query($query);
					
							$amount_gs = mysqli_num_rows($result);
					
							if($amount_gs > 0)
							{
								$i = 0;
								
								$output .= '<h1>Hersteller ( '.$amount_gs.' )</h1>';
								$output .= '</div>';
								$output .= '<ul>';
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									if($i == 2)
									{
										$output .= '</ul>';
										$output .= '<ul>';
										
										$i = 0;
									}
									
									$output .= '<li class="col-l6">';
									$output .= '<div class="margin container dark">';
									$output .= '<p>'.$row['vendor_name'].'</p>';
									$output .= '</div>';
									$output .= '</li>';
									
									$i++;
								}
								
								$output .= '</ul>';
							}
							else
							{
								$output .= '<div class="panel light-marine">';
								$output .= '<p>Es wurden keine Eintr&auml;ge gefunden.</p>';
								$output .= '</div></div>';
							}
							
							break;
							
						case $allowed_category[2]:
							
							$query = "
							SELECT model_id,model_name
							FROM model";
							
							$result = $sql->query($query);
					
							$amount_gs = mysqli_num_rows($result);
					
							if($amount_gs > 0)
							{
								$i = 0;
								
								$output .= '<h1>Modelle ( '.$amount_gs.' )</h1>';
								$output .= '</div>';
								$output .= '<ul>';
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									if($i == 2)
									{
										$output .= '</ul>';
										$output .= '<ul>';
										
										$i = 0;
									}
									
									$output .= '<li class="col-l6">';
									$output .= '<div class="margin container dark">';
									$output .= '<p>'.$row['model_name'].'</p>';
									$output .= '</div>';
									$output .= '</li>';
									
									$i++;
								}
								
								$output .= '</ul>';
							}
							else
							{
								$output .= '<div class="panel light-marine">';
								$output .= '<p>Es wurden keine Eintr&auml;ge gefunden.</p>';
								$output .= '</div></div>';
							}
							
							break;
						
						case $allowed_category[3]:
							
							$query = "
							SELECT type_id,type_name
							FROM type";
							
							$result = $sql->query($query);
					
							$amount_gs = mysqli_num_rows($result);
					
							if($amount_gs > 0)
							{
								$i = 0;
								
								$output .= '<h1>Typen ( '.$amount_gs.' )</h1>';
								$output .= '</div>';
								$output .= '<ul>';
								
								while($row = $result->fetch_array(MYSQLI_ASSOC))
								{
									if($i == 2)
									{
										$output .= '</ul>';
										$output .= '<ul>';
										
										$i = 0;
									}
									
									$output .= '<li class="col-l6">';
									$output .= '<div class="margin container dark">';
									$output .= '<p>'.$row['type_name'].'</p>';
									$output .= '</div>';
									$output .= '</li>';
									
									$i++;
								}
								
								$output .= '</ul>';
							}
							else
							{
								$output .= '<div class="panel light-marine">';
								$output .= '<p>Es wurden keine Eintr&auml;ge gefunden.</p>';
								$output .= '</div></div>';
							}
							
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