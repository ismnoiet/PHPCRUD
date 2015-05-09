<?php 

require_once 'attribute.php';
require_once 'table.php';
	
	$tableString = 'create table test(attr1 varchar(50),attr2 int(10),attr3 date(),attr4 varchar(10));';
	$table = new table($tableString);
	// 1 : get the table name 
	echo $table->name."\n";
	// 2 : get the string representation of that table 
	echo $table->toString()."\n";
	// 3 : get a list of attributes
	print_r($table->attributes);
	// 4 : generate all the crud methods and save them to test.php :
	$table->crud('test.php');
?>

