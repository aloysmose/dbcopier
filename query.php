<?php

/**
 * DB table fields Copier v.1.0
 * @autor: Alex Lifantyev <al@arte.kz>
 */

require_once('./config.php');

$db = (!empty($_GET['db'])) ? $mysqli->real_escape_string(strip_tags($_GET['db'])) : NULL;
$table = (!empty($_GET['table'])) ? $mysqli->real_escape_string(strip_tags($_GET['table'])) : NULL;

if ($table && $db) {
	$query = 'SHOW COLUMNS FROM '.$db.'.'.$table;
} else if ($db) {
	$query = 'SHOW TABLES FROM '.$db;
} else {
	echo '<option>No database or table selected</option>';
	die;
}

$result = $mysqli->query($query);

if ($result) {
	while ($row = $result->fetch_array()) {
		if ($table) {
			echo '<option value="'.$row['Field'].'">'.$row['Field'].'&nbsp;&nbsp;&nbsp;'.$row['Type'].'&nbsp;&nbsp;'.$row['Key'].'&nbsp;'.$row['Extra'].'</option>';
		} else {
			$q = 'SELECT COUNT(*) FROM '.$db.'.'.$row[0];
			$res = $mysqli->query($q);
			 if ($res) {
			 	$res = $res->fetch_array();
				$res = $res[0];
			 } else {
			 	$res = 0;
			 }
			echo '<option value="'.$row[0].'">'.$row[0].'&nbsp;&nbsp;&nbsp;Rows: '.$res.'</option>';
		}
	}
}

if ($mysqli) $mysqli->close();
unset($mysqli);
?>