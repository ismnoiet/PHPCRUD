## PHPCrud
A DSL php module to generate php file containing all CRUD(Create,Read,Update,Delete) operations related to a given table description. 

Normally the sql(mysql for example) query used to create  "user" table is something like this :
​
```sql
CREATE TABLE user(id int(10) primary key auto_increment,name varchar(100));
```
Well, in this example
* we have a table with the name of user 
* we have the id column(currently, in this module  the first column is considered the primary key)
* we have also the name column


to generate CRUD operations for the previous table(user) using our PHPCrud module, we have to follow the next instructions : 



```php
​
// 1 : inside your main.php or index.php load the table module    
    require_once('modules/table.php');
    
// 2 : create an instance of the Table module
    $table = new Table();
    
	// 2.1 give the table a name 
	$table->name('user');
	// 2.2 add the id column, equivalent to "id int(3)"
	$table->add()->name('id')->type('int')->size('3')->close();  
	// 2.3 add the name column, equivalent to "name varchar(50)"
	$table->add()->name('name')->type('varchar')->size('50')->close();


// 3 : generate the output file,if no argument is passed to generate() method 	 
//     then the default path is used, which is "tables/tableName.php"


$table->generate();  //  "tables/user.php" file is generated in this case because the name of table is user
$table->generate('myname'); // the output is "tables/myname.php"
```  



see the provided [example](./example.php)
