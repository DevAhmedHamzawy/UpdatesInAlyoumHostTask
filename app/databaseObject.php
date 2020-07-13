<?php 

  class databaseObject{

      // DB stuff
      protected $conn;

      // Constructor with DB
      public function __construct($db) { $this->conn = $db; }


      // Prepare DB Connection
      public function prepareConnection($q){ return $this->conn->prepare($q); }
  

      // Bind Values To Query Then Execute
      public function executeQuery($q, $a)
      {
  
        // Prepare statement
        $s = $this->prepareConnection($q);
  
        // Loop Through The Params Of Query To Bind
        foreach($a as $k => &$v) { $s->bindParam($k, htmlspecialchars(strip_tags($v))); }
  
        // Execute query
        if($s->execute()){ return $s; } else { printf("Error: %s.\n", $s->error); return false; };
        
      }
  }