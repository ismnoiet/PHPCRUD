<?php 
	
	// 1 : load the table module 	
	require_once('modules/table.php');
	
	// 2 : create an instnce of the Table module
	$table = new Table();

	// 3 : configuring the new create table 
		
		// 3.1 give the table a name 
		 $table->name('user');
		 // 3.2 add the id column
		 $table->add()->name('id')->type('int')->size('3')->close();
		 // 3.3 add the name column 
		 $table->add()->name('name')->type('varchar')->size('50')->close();
		 
	// 4 : export the newly created table class to "tables" directory	 
	echo $table->export();	 

?>
