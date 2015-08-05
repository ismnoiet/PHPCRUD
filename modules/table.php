<?php 

require_once('attribute.php');

class Table{
		public $attributes,
		       $attributes_names,
			   $values,
			   $pattern,
			   $name,
			   $string,
			   $attributesString,
			   $methods; // contains all the different methods to perform crud operations

		function __construct(){
			
		}

		function toString(){
			$str = 'create table '.$this->name.'( ';
			$tmp = array();	
			for ($i=0; $i <count($this->attributes) ; $i++) { 
				$tmp[] = $this->attributes[$i]->toString();
			}			

			$a = implode(',', $tmp);
			$str .=$a.' )';
			return $str;	

		}

		function name($name){
			$this->name = $name;
			return $this;
		}

		function add(){
			$tmp = new Attribute();
			$tmp->parent = $this;
			$this->attributes[] = $tmp;
			$this->values[] = '?';
			return $tmp;
		}

		function create(){
			$str  = "<?php\n"; // begin of the file 
			$str .= "class ".$this->name."{\n";
			$str .= "	function __construct(){\n";
			$str .= "		require_once('../modules/connection.php');\n";			
			$str .= "		\$con = new Connection();\n";			
			$str .= "		\$this->db = \$con->db;\n";			
			$str .= "	}\n";			

			$fn = function($attribute){
				return '$'.$attribute;
			};

			$arguments = array_map($fn, $this->attributes_names);


			$str .= '	function create('.implode(',',$arguments)."){\n";
			$str .= "		\$sql = 'INSERT INTO ".$this->name;
			$str .= " VALUES(".implode(",",$this->values).")';\n";
			$str .= "        \$query = \$this->db->prepare(\$sql);\n";
			$str .= "        \$query = \$query->execute(array(".implode(',',$arguments)."));\n";
			$str .= "	}\n";			
			return $str;
		}

		function read(){
			$str  = "    function read(\$".$this->attributes_names[0]."){\n";
			$str .= "		\$sql = 'SELECT * FROM ".$this->name;
			$str .= " WHERE ".$this->attributes[0]->name." = ?';\n";
			$str .= "        \$query = \$this->db->prepare(\$sql);\n";
			$str .= "        \$query->execute(array($".$this->attributes_names[0]."));\n";
			$str .= "        return \$query->fetch(PDO::FETCH_ASSOC);\n";
			$str .= "    }";
			return $str;
		}


		function update(){

			$fn = function($attribute){
				return '$'.$attribute;
			};
			$arguments = array_map($fn, $this->attributes_names);

			$str  = "    function update(".implode(',',$arguments)."){\n";
			$str .= "		\$sql = 'UPDATE ".$this->name;

			

			$func = function($attribute){
				return $attribute." = ?";
			};
			
			$tmp = array_map($func,$this->attributes_names);
			$tmp = implode(',',$tmp); // attr1 = ?, attr2 = ? etc.
			
			$str .= " SET ".$tmp;
			$str .= " WHERE ".$this->attributes[0]->name." = ?';\n";
			$str .= "        \$query = \$this->db->prepare(\$sql);\n";
			$str .= "        \$query->execute(array(".implode(',',$arguments).",$".$this->attributes_names[0]."));\n";
			$str .= "        return \$query->rowCount();\n";
			$str .= "    }";
			return $str;				
		}

		function delete(){
			$str  = "    function delete(\$".$this->attributes_names[0]."){\n";
			$str .= "		\$sql = 'DELETE FROM ".$this->name;
			$str .= " WHERE ".$this->attributes[0]->name." = ?';\n";
			$str .= "        \$query = \$this->db->prepare(\$sql);\n";
			$str .= "        \$query->execute(array($".$this->attributes_names[0]."));\n";
			$str .= "        return \$query->rowCount();\n";
			$str .= "    }\n";
			return $str;
		}

		function export($filename=""){
			$file = '';	
			$str  = $this->create();
			$str .= "\n".$this->read();
			$str .=  "\n".$this->update();
			$str .=  "\n".$this->delete();
			$str .="}\n"; // end of the table class
			$str .="?>\n"; // end of the table class
			

			if($filename !=''){
				$file = $filename;
			}else{
				// create a file with the same table name inside the tables folder	
				$file = $this->name; 				
			}

			$file = dirname(__DIR__) . "/tables/".$file.".php";
			echo $file;

			$fh = fopen($file,"w");
			if($fh){
				fwrite($fh, $str);
				fclose($fh);
				return 1;							
			}
			return 0;			

		}

		

	}

// $table = new Table();
// $table->name('table1')->add()->name('id')->type('int')->size('10')->close()
//       ->add()->name('name')->type('varchar')->size('100')->close();
// echo $table->toString();      

// echo $table->create();
// echo $table->read();
// echo $table->update();
// echo $table->delete();
?>
