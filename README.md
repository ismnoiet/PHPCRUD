## PHPCrud
A DSL php module to generate php file containing all CRUD(Create,Read,Update,Delete) operations related to the table description 

```php
​
// 1 : load the table module    
    require_once('modules/table.php');
    
// 2 : create an instance of the class Table
    $table = new Table();
    
// 3 : add a name for the table to be created 
    $table->name('user') 
​
// 4 : add the table definition 
​
```  
Normally the mysql query used to create  "user" table is something like this :
​
```sql
CREATE TABLE user(id int(10) primary key auto_increment,name varchar(100));
```
Well, in this example
* we have a table with the name of user 
* we have the id column
* we have also the name column
