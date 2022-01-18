<?php
	//Парсер инвентаря ARTIFACT
	$steamID = array
	(
	'76561198052094068',
	'76561198195597575'
	);

	$titles = array('SteamID', '#', 'assetid', 'classid', 'instanceid', 'Иконка', 'Наименование', 'Редкость', 'Тип предмета', 'Тип карты', 'Цвет карты', 'Серия карты', 'Расход маны', 'Цена в золоте', 'Можно продать', 'Можно передать');
	$categories = array ('Rarity', 'Item_Type', 'Card_Type', 'Card_Color', 'Set', 'Mana_Cost', 'Gold_Cost');
	$counter = 1;
	$countCategories = count($categories,COUNT_NORMAL);
	
	echo '<pre>';
	echo '<table border="1">';
	echo '<tr>';
	foreach ($titles as $value)
	{
		echo '<td>';
		echo $value;
		echo '</td>';
	}
	echo '</tr>';
	
	foreach ($steamID as $value)
		{	
			$inventoryJsonUrl = 'http://steamcommunity.com/inventory/'.$value.'/583950/2?l=russian&count=5000';
			$currentSteamID = $value;
			$inventoryJsonGet = file_get_contents($inventoryJsonUrl);
			$inventories = json_decode($inventoryJsonGet , TRUE);
	
			foreach ($inventories['assets'] as $key => $assetid)
				{
					echo '<tr>';
					echo '<td>';
					echo $currentSteamID;
					echo '</td>';
					echo '<td>';
					echo $counter++;
					echo '</td>';
					echo '<td>';
					echo $assetid["assetid"];
					echo '</td>';
					echo '<td>';
					echo $assetid["classid"];
					echo '</td>';
					echo '<td>';
					echo $assetid["instanceid"];
					echo '</td>';
					foreach ($inventories['descriptions'] as $key => $description)
					{
						if ($assetid["classid"] == $description['classid'] && $assetid["instanceid"] == $description['instanceid'])
						{
												echo '<td>';
					echo '<img src=\'https://steamcommunity-a.akamaihd.net/economy/image/'.$description['icon_url'].'/50x50f\'>';
					echo '</td>';
							echo '<td>';
							echo $description['name'];
							echo '</td>';
							foreach ($categories as $value)
							{
								$counterNull = 0;
								echo '<td>';
								for ($x=0; $x<$countCategories; $x++)
								{
									if ($description['tags'][$x]['category'] == $value)
									{
										$localizedTagName = $description['tags'][$x]['localized_tag_name'];
										$color = $description['tags'][$x]['color'];
										
										if ($value == Card_Type)
										{
											$cardType = $localizedTagName;
										}
										
										if ($value == Card_Color)
										{
										if ($localizedTagName == Зелёная)
										{
											$color = '479036';
										}
										else if ($localizedTagName == Чёрная)
										{
											$color = '736e80';
										}
										else if ($localizedTagName == Синяя)
										{
											$color = '2f7492';
										}
										else if ($localizedTagName == Красная)
										{
											$color = 'c2352d';
										}
									}	

										
										if ($color == '')
										{
										echo $localizedTagName;
										}
										else
										{
										echo '<span style="Color:#'.$color.';font-weight: bold">'.$localizedTagName.'</span>';	
										}
									}
									else
									{
										$counterNull++;
									}
									
									if ($counterNull == $countCategories)
									{
										if ($value == Card_Color)
										{
											if ($localizedTagName == Предмет)
											{
												$color = 'dcaf4e';
												echo '<span style="Color:#'.$color.';font-weight: bold">Золотая</span>';	
											}
											else
											{
												echo 'Нет';
											}
										}
										else if ($value == Mana_Cost)
										{
											echo '0 маны';
										}
										else if ($value == Gold_Cost)
										{
											echo '0 золота';
										}
										else
										{
											echo 'Нет';
										}
									}
								}
								echo '</td>';
							}
							echo '<td>';
							echo $description["marketable"];
							echo '</td>';
							echo '<td>';
							echo $description["tradable"];
							echo '</td>';
						}
					}
					echo '</tr>';
				}
	}
	echo '</table>';
	echo '<pre>';
?>
