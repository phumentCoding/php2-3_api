<?php

   include "../config.php";

   header("Content-Type: application/json");
   header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");  
   header("Access-Control-Allow-Origin: *");  //http://localhost:3000 , http://localhost:5017

   //convert json requestion from client side to associtave array
   $data = json_decode(file_get_contents("php://input"),true);

   /*
        Request data 
            {
                "name": "Kok",
                "gender": "Male",
                "address": "Kok",
                "phone": "034564646",
                "email": "kok@gmail.com"
            }

       => [
            "name" => "KoK",
            "gender" => "Male",
            "address" => "Kok",
            "phone" => "034564646",
            "email" => "kok@gmail.com"
          ]

        $data["name"]
    */

  
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
            try{
                $id = $_GET['id'];
                $sql = "SELECT * FROM students WHERE id = $id";
                $result = mysqli_query($con,$sql);

                if(!$result){
                    throw new Exception(mysqli_error($con));
                }

                $student = mysqli_fetch_assoc($result);

                http_response_code(200);

                echo json_encode([
                    'status' => true,
                    'message' => 'Get question success with id '.$id,
                    'data' => [
                        'student' => $student
                    ]
                ]);

            }catch(Exception $e){
                http_response_code(500);
                echo json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
            }
            
        }

        break;
      } 

      case 'POST' : {
        try{
            $name = $data['name'] ?? null;
            $gender = $data['gender'] ?? 'Other';
            $address = $data['address'] ?? null;
            $phone = $data['phone'] ?? null;
            $email = $data['email'] ?? null;

            //i want inserte data to db
            $sql = "INSERT INTO students(name,gender,address,phone,email) 
            VALUES('$name','$gender','$address','$phone','$email')";

            $result = mysqli_query($con,$sql);

            if(!$result){
                throw new Exception(mysqli_error($con));
            }

            http_response_code(200);

            echo json_encode([
                'status' => true,
                'message' => 'Insert student success',
                'data' => [
                    'student' => [
                        'id' => mysqli_insert_id($con),
                        'name' => $name,
                        'gender' => $gender,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email
                    ]
                ]
            ]);

        }catch(Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;
      }

      case 'DELETE' : {
        try{
            $id = $_GET['id'];
            $sql = "DELETE FROM students WHERE id = $id";
            $result = mysqli_query($con,$sql);

            if(!$result){
                throw new Exception(mysqli_error($con));
            }

            http_response_code(200);

            echo json_encode([
                'status' => true,
                'message' => 'Delete question success with id '.$id
            ]);
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;
      }
   }

   

?>