<?php 
class Validation{
	
    public $required_fields;
    public $fields_with_max_length;
    public static $errors = array();
    
    public function fieldname_as_text($field_name){
    $field_name = str_replace("_"," ",$field_name);
    $field_name = ucfirst($field_name);
    return $field_name;
    }
    // * presence
    // use trim() so empty spaces don't count
    // use === to avoid false positives
    // empty() would condsider "0" to be empty
    public static function has_presence($value){
      return isset($value) && $value !== "";  
    }
    public static function validate_presence($required_fields){
  
    foreach($required_fields as $field => $value){
          $value = trim($value);
          if(!self::has_presence($value)){
          self::$errors[$field] = self::fieldname_as_text($field)." can't be blank";
          echo self::$errors[$field];
     }
    }
    }
    // * string length
    // * max length
    public static function has_max_length($value , $max){
       return strlen($value) <= $max;
    }
    public static function validate_max_length($fields_with_max_length){
  
    foreach($fields_with_max_length as $field => $max){
          $value = trim($field);
          if(!self::has_max_length($value , $max)){
         self::$errors[$field] = self::fieldname_as_text($field)."  is too long";
     }
    }
    }
}  