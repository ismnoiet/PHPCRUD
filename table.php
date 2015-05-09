<?php 
class Table{
		public $attributes;
		public $pattern;
		public $name;
		public $string;
		public $attributesString;
		public $methods; // contains all the different methods to perform crud operations

		function __construct($string){
			$this->string  = $string;
			$this->pattern = '(.+?)[\s](.+?)\((.+?)\)(,|)';
			$namePattern = 'create table (.+?)\((.*?)\);';
			preg_match_all('/'.$namePattern.'/',$string, $matches);
			$this->name = $matches[1][0];
			$this->attributesString = $matches[2][0];


			preg_match_all('/(.+?)[\s](.+?)\((.*?)\)(?:,|)/',$this->attributesString,$attrs);

			// setting the names for the attributes 
			for($i=0;$i<count($attrs[1]);$i++){
				$this->attributes[$i]  = new attribute('','','','');				
				$this->attributes[$i]->name  = $attrs[1][$i];		
				// setting the types for the attributes 
				$this->attributes[$i]->type  = $attrs[2][$i];		
				// setting the types for the attributes 	
				$this->attributes[$i]->length  = $attrs[3][$i];				
			}				
			// echo $this->attributes[1]->toString();			
		}

		function toString(){
			return $this->string;	
		}

		function attributesNames(){
			$arr = array();	
			foreach ($this->attributes as $attribute) {
				$arr[] = '$'.$attribute->name;	
			}
			return $arr;
		}

		function read(){
			
			$readQuery = 'SELECT * FROM '.$this->name.' WHERE '.$this->attributes[0]->name.' = ?';						
			$readMethod = 'function read'.ucwords($this->name).'(';
						
			$readMethod .= "\$".$this->attributes[0]->name."){";
			$readMethod .="\n  \$query = \$this->db->prepare(\"".$readQuery."\");";
			$readMethod .="\n  \$query->execute(array($".$this->attributes[0]->name."));";
			$readMethod .="\n  if(\$query){ return \$query->fetchAll(PDO::FETCH_ASSOC);}";
			$readMethod .="\n  return -1;";
			$readMethod .="\n}";
			$obj = new stdClass();
	
			$obj->readMethod = $readMethod;
			$obj->readQuery = $readQuery;

			return $obj;
		}

		function create(){
			$createQuery = 'INSERT INTO '.$this->name.' VALUES(';
			$createMethod = 'function create'.ucwords($this->name).'(';

			for($i=0;$i <count($this->attributes)-1;$i++){				
				$createQuery  .='?,';
				$createMethod .='$'.$this->attributes[$i]->name.',';
			}
			
			$createQuery .= '?)';
			$createMethod .="\$".$this->attributes[$i]->name.'){';
			$createMethod .="\n  \$query = \$this->db->prepare('".$createQuery."');";
			$createMethod .="\n  \$query->execute(array(".join(',',$this->attributesNames())."));";
			$createMethod .="\n  if(\$query){ return 1;}";
			$createMethod .="\n  return -1;";
			$createMethod .="\n}";
			$obj = new stdClass();
			$obj->createMethod = $createMethod;
			$obj->createQuery = $createQuery;	
			return $obj;
		}

		function update(){
			$updateQuery = 'update '.$this->name.' SET ';
			$updateMethod = 'function update'.ucwords($this->name).'(';

			for($i=0;$i <count($this->attributes)-1;$i++){				
				$updateQuery  .=$this->attributes[$i]->name." = ? , " ;
				$updateMethod .='$'.$this->attributes[$i]->name.',';
			}
			
			$updateQuery .= $this->attributes[$i]->name." = ? ";
			$updateMethod .="\$".$this->attributes[$i]->name.'){';
			$updateMethod .="\n  \$query = \$this->db->prepare('".$updateQuery."');";
			$updateMethod .="\n  \$query->execute(array(".join(',',$this->attributesNames())."));";
			$updateMethod .="\n  if(\$query){ return 1;}";
			$updateMethod .="\n  return -1;";
			$updateMethod .="\n}";
			$obj = new stdClass();
			$obj->updateMethod = $updateMethod;
			$obj->updateQuery = $updateQuery;	
			return $obj;
		}

		function delete(){
			$deleteQuery = 'delete FROM '.$this->name.' WHERE ';
			$deleteMethod = 'function delete'.ucwords($this->name).'(';

			$deleteQuery  .=$this->attributes[0]->name." = ? " ;
			$deleteMethod .='$'.$this->attributes[0]->name.'){';
			
			$deleteMethod .="\n  \$query = \$this->db->prepare('".$deleteQuery."');";
			$deleteMethod .="\n  \$query->execute(array(\$".$this->attributes[0]->name."));";
			$deleteMethod .="\n  if(\$query){ return 1;}";
			$deleteMethod .="\n  return -1;";
			$deleteMethod .="\n}";
			$obj = new stdClass();
			$obj->deleteMethod = $deleteMethod;
			$obj->deleteQuery = $deleteQuery;	
			return $obj;			
		}

		function value($type,$value){
			if($type == 'int'){
				return (int)$value;
			}
			if($type =='varchar'){
				return "'".$value."'";
			}
			if($type == 'date'){
				return "'".date('Y-m-d H:i:s')."'";
			}
			return $value;
		}

		function crud($fileName){
			
				$constructor = "\n     function __construct(){\n";
				$constructor.= "       require_once('connection.php');\n";
				$constructor .= "      \$con = new connection();\n";
				$constructor .= "      \$this->db = \$con->db;\n";
				$constructor .= "   }\n";

				$create = $this->create();				
				$read = $this->read();								
				$delete = $this->delete();				
				$crudStr  = '';
				$crudStr .="<?php\n";		
				$crudStr .= "class ".ucwords($this->name)."{";
				$crudStr .= $constructor;
				$crudStr .="\n".$create->createMethod;		
				$crudStr .="\n".$read->readMethod;		
				$crudStr .= "\n".$delete->deleteMethod;		
				$crudStr .= "\n}";							
				$crudStr .= "\n?>";							

				$fh = fopen($fileName, 'w');
				fwrite($fh, $crudStr);
				fclose($fh);
				return $crudStr;
		}		
	}
	
?>