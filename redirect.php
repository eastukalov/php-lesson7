<?php
		$dir='test/';
		
		if (isset($_FILES['myfile']['name']) && !empty($_FILES['myfile']['name']))	{
			
			if (is_dir($dir) && $_FILES['myfile']['error']==UPLOAD_ERR_OK && isset($_FILES['myfile']['type']) && ($_FILES['myfile']['type']=='application/json') && 
				move_uploaded_file($_FILES['myfile']['tmp_name'], 'test/' . $_FILES['myfile']['name'])) {			
				header('Location: list.php');
			}
			else {
				header('Location: admin.php');
			}
		}
		else
		{
			header('Location: admin.php');
		}
			
?>