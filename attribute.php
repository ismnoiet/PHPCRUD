<?php 
    class Attribute{
        public $name;
        public $type;
        public $length;
        public $other;
        
        function __construct($name,$type,$length,$other){
            $this->name = $name;
            $this->type = $type;
            $this->length = $length;
            $this->other = $other;
            
        }
    
        /**
         * like Java toString method 
         * @return [String] [a string representation of  all  properties of that object]
         */
        
        function toString(){
            return $this->name.' '.$this->type.'('.$this->length.')'.' '.$this->other;
        }
    }
?>