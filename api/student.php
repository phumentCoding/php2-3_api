<?php

   include "../config.php";

   header("Content-Type: application/json");
   header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
   header("Access-Control-Allow-Origin: *");  //http://localhost:3000 , http://localhost:5017

   //convert json requestion from client side to associtave array
   $data = json_decode(file_get_contents("php://input"),true);

  
   $method = $_SERVER['REQUEST_METHOD'];  

   switch($method){
      case 'GET' : {
        if(!isset($_GET['id'])){
            
            try{
                $sql = "SELECT * FROM students";
                $result = mysqli_query($con,$sql);

                if(!$result){
                    throw new Exception("Error: " . mysqli_error($con));
                }

                $students = mysqli_fetch_all($result,MYSQLI_ASSOC);

                http_response_code(200);
                
                echo json_encode([
                    'status' => true,
                    'message' => 'selected all students successfully',
                    'data' => [
                        'students' => $students
                    ]
                ]);

            }catch(Exception $e){
                http_response_code(500);
                echo json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
            }

            
        }else{

        }

        break;
      }
   }

   

?>