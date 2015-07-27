<?php 
	
	// 1 : load the table module 	
	require_once('modules/table.php');
	// 2 : create an instnce of the Table module
	$table = new Table();

	// 3 : configuring the new create table 
	// $table->name('table1');
	// $table->add()->name('id')->type('int')->size('10')->close()
	//       ->add()->name('name')->type('varchar')->size('100')->close();



	 $table->name('user');
	 $table->add()->name('id')->type('int')->size('3')->close();
	 $table->add()->name('name')->type('varchar')->size('50')->close();
	 

	 

	// echo $table->toString();      

	// echo $table->create();
	// print_r($table->read(3));
	// echo $table->update();
	// echo $table->delete();
	
	// $a = new table1();
	// print_r($a->read(3));
	
	// 4 : exporting the newly created table class	 
	echo $table->export();	 

?>
