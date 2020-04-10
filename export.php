<?php
			session_start();
			include "config.php";
			$conn;
			if (isset($_POST['Download'])){
				$selectedTable = $_POST['TABLE_NAME'];
				header('Content-Type: text/csv; charset=utf-8');  
				header("Content-Disposition: attachment; filename=$selectedTable.csv");  
				$output = fopen("php://output", "w");    
				$query = "SELECT * FROM $selectedTable";  
				$result = mysqli_query($conn, $query);  
				while($row = mysqli_fetch_assoc($result))  
				{  
					fputcsv($output, $row);  
				}  
				fclose($output);  
			}
			?>