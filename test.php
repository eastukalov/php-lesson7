<?php

	if (isset($_GET['rb']) && !empty($_GET['rb'])) {
		
		if (is_readable($_GET['rb'])) {
			$tests=htmlspecialchars(file_get_contents($_GET['rb']));
			$tests=json_decode(file_get_contents($_GET['rb']),true);
			$check = false;

			if (count($tests)==0) {
				$check = true;
			}	
			else {
									
				foreach ($tests as $value) {
					//переиндексирование массива
					$value=array_values($value);

					
					foreach ($value as $key=>$test) {
							
						switch ($key) {
							case 0:
								if (!is_string($test)) {
									$check=true;
									break(3);
								}
								break;
							case 1:
								if (!is_array($test) || count($test)==0) {
									$check=true;
									break(3);
								}

								if (array_sum(array_count_values($test))!=count(array_count_values($test))) {
									$check=true;
									break(3);
								}
								
								break;
							case 2:
								if (!is_array($test) || count($test)==0) {
									$check=true;
									break(3);
								}	

								if (array_sum(array_count_values($test))!=count(array_count_values($test))) {
									$check=true;
									break(3);
								}
								
								break;
							default:
								$check=true;
								break(3);
						}

						if (count($value[1]) < count($value[2])) {
							$check=true;
							break(2);
						}
					}
				}	

			}

			if ($check) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
				echo 'Ошибка: неправильная структура файла';
			}

		}
		else {
			$check=true;
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
			echo 'Ошибка: указанный тест не найден';
		}
	}	
	else {
		$check=true;
		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		echo 'Ошибка: не задан тест';
	}

	if (!$check) {
		?>
		<html>
		<head>
			<title>Тест</title>
			<style type="text/css"> .score {display: none}</style>
		</head>
		<body>
		<form method='POST'>
		<p>ФИО<input type="text" name="fio" placeholder='ФИО'></p>
		<?php

		foreach ($tests as $key_test=>$value) :
			
			foreach ($value as $key=>$test) :
				
				switch ($key) {
					case 0:
						echo "<h3>Вопрос: $test</h3>";
						break;
					
					case 1:
						foreach ($test as $key_variant => $variant) :
							?> <input type='checkbox' name=<?='res['.$key_test.']['.$key_variant.']' ?> value=<?='"'.urlencode($variant) .'"'?>><?=$variant?> <?php
						endforeach;
						break;
					case 2:
						$ansvers[]=$test;
						break;	
				}
							
			endforeach;
			
		endforeach;

		?> <p><input type='submit' value='Отправить'></p> 
		<?php

		if (isset($_POST['res']) && !empty($_POST['res'])) {	
			
			if (count($_POST['res'])!=3) {
				$check=true;
			}
		}
		else {
			$check=true;
		}	

		if ($check) {
			echo '<p>Вы пока еще не выполнили тест полностью</p>';
		}

		if (!isset($_POST['fio']) || empty($_POST['fio'])) {	
			echo '<p>Вы не зарегестрировались</p>';
			$check=true;
		}

		$score='зачет';

		if (!$check) {
			echo "<h4>Вы дали ответы :</h4>";
			foreach ($_POST['res'] as $key=>$result) {
				$ans=implode(" - , - ", $ansvers[$key]);
				$res=urldecode(implode(" - , - ", $result));
				echo '<p>'.$res.'</p>';

				if ($ans==$res) {
					echo '<p style="color:green">Ответ правильный</p>';
				}
				else {
					$score='не зачет';
					echo '<p style="color:red">Правильный ответ: '.$ans.'</p>';
				}				
						
			}

			$get='"image.php?score=' . urlencode($score) . '&fio=' . urlencode($_POST['fio']) . '"';
			?><img src=<?=$get?>><?php
		}

		?>

		</form> 
		</body>
		</html>
		<?php
	}

	echo "<p><a href='admin.php'>возврат к загрузке тестов</a></p>";
	echo "<p><a href='list.php'>возврат к выбору теста</a></p>";
?>

