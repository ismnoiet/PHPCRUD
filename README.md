## PHPCrud
A fluent php module to generate php file containing all CRUD(Create,Read,Update,Delete) operations related to a given table description. 

### What's included 
this module include three classes,**connection** class to deal with everything related to connection with DB, **attribute** class as its name says it is used to hold attributes informations and finally the **table** class which requires both connection and attribute classes

```
project/
├── modules/
│   ├── connection.php 
│   ├── attribute.php 
│   └── table.php  
│   
└── tables/
```

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

before we get our hands on coding, we should change the database connection informations to suite our configuration. 
inside " modules/connection.php" change the following informations :
​
```php
        public $HOST = 'localhost'; // host name, localhost in case we are working locally
        public $DB_NAME = 'abc';  // database name
        public $USER_NAME = 'root'; // user name 
        public $PASSWORD = 'password'; // password for the selected user 
```
Once the connection is istablished with  the database, then we play with PHPCrud  module

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
