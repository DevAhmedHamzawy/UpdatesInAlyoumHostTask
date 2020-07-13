<?php

  error_reporting(E_ALL ^ E_NOTICE);

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');



  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate son object
  $son = new Person($db);

  // Instantiate father object
  $father = new Person($db);

  // Instantiate grand father object
  $grandfather = new Person($db);


  // Instantiate Person Object
  $person = new Person($db);