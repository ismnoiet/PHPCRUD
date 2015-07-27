<?php 
    class Attribute{
        public $name,
               $type,
               $length,
               $other,
               $parent,
               $primary;               
        
        function __construct(){            
              
        }
    
        /**
         * like Java toString method 
         * @return [String] [a string representation of  all  properties of that object]
         */
        
        function toString(){
            return $this->name.' '.$this->type.'('.$this->size.')'.' '.$this->other;
        }


        function name($name){
            $this->name = $name;
            return $this;
        }

        function type($type){
            $this->type = $type;
            return $this;
        }

        function size($size){
            $this->size = $size;
            return $this;
        }

        function primary(){

        }

        function close(){
            $this->parent->attributes_names[] = $this->name;
            return $this->parent;
        }


    }

   //  $a = new Attribute();
   //  $a->name('first') 
   //    ->type('varchar')
   //    ->size(100);

   // echo $a->toString();
?>
