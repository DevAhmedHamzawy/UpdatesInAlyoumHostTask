<?php 

  include_once '../../app/init.php';
  include_once '../../app/validation.php';

  // Get raw personed data
  $data = json_decode(file_get_contents("php://input"));


  //validations For Presence
  $required_fields = array('name' => $data->name, 'birthdate' => $data->birthdate , 'latitude' => $data->lat, 'longitude' => $data->lng);
  //if($data->type !== 'son') { $required_fields['person_id'] = $data->person_id; }
	Validation::validate_presence($required_fields);
  
  //validations For Max Length
	$fields_with_max_length =array($data->name => 500);
	Validation::validate_max_length($fields_with_max_length);
	
  
  // if Errors It Will Be Shown
	if(!empty(Validation::$errors)){		
    http_response_code(422);
    echo json_encode(Validation::$errors);
	  die();
	}
  
  
  // Reform Name - Type - Person Id
  $family_name = explode(" ", $data->name);

  // Initialize family names
  $son->name = $family_name[0];
  $father->name = $family_name[1];
  $grandfather->name = $family_name[2];

  // Initialize Inputs
  $son->lat = $data->lat;
  $son->lng = $data->lng;
  $father->lat = $data->lat;
  $father->lng = $data->lng;
  $grandfather->lat = $data->lat;
  $grandfather->lng = $data->lng;
  $son->type = "son";
  $father->type = "father";
  $grandfather->type = "grandfather_father";


  // Reform Date Input for son
  $time = strtotime($data->birthdate);
  $newFormat = date("Y-m-d", $time);
  $son->birthdate = $newFormat;


  // Create son - father - grandfather
  if($result_grandfather = $grandfather->create()) {

    $grandfather->id = $result_grandfather; $grandfather->person_id = $result_grandfather;  $grandfather->update();
    
    $father->person_id = $result_grandfather;

    if($result_father = $father->create()) { $father->id = $result_father; $son->person_id = $result_father; }

    if($result_son = $son->create()) { $son->id = $result_son; echo json_encode(['son' => $son, 'father' => $father, 'grandfather' => $grandfather]);  }

  } else {
    echo json_encode(array('message' => 'Something is wrong Please Try Again'));
  }
