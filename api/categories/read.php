<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Init DB & connect 
  $database = new Database();
  $db = $database->connect();

  // Init blog categories object 
  $categories = new Category($db);

  $result = $categories->read();

  $num = $result->rowCount();

    // Check if any categories
    if($num > 0) {
      // categories array
      $categories_arr = array();
      $categories_arr['data'] = array();
  
      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
  
        $categories_item = array(
          'id' => $id,
          'name' => $name,
        );
  
        // Push to "data"
        array_push($categories_arr['data'], $categories_item);
      }
  
  
      // Turn to JSON & output
      echo json_encode($categories_arr);
  
    } else {
      // No categories
      echo json_encode(
        array('message' => 'No Categories Found')
      );
    }