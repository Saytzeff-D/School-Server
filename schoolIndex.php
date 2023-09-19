<?php
    header("Access-Control-Allow-Origin:http://localhost:8080");
    header("Access-Control-Allow-Headers: Content-Type");
      class Connection{
          public  $server = 'localhost';
          public $username = 'root';
          public $password = '';
          public $dbName = 'school_db';
          public $connect;
          public function __construct()
          {
              $this->connect = new mysqli($this->server, $this->username, $this->password, $this->dbName);
          }
          
      }

      class Application extends Connection{
          public function saveApplicant($surname, $firstname, $middleName, $dob, $gender, $entryType, $phoneNum, $email, $stateOrigin, $passport)
          {
            if (!empty($surname) and !empty($firstname) and !empty($middleName) and !empty($dob) and !empty($gender) and !empty($entryType) and !empty($phoneNum) and !empty($email) and !empty($stateOrigin)) {
                $insertApplicantData = "INSERT into applicant (surname, first_name, middle_name, dob, gender, entry_type, phone_num, email, state_of_origin, passport) VALUES('$surname', '$firstname', '$middleName', '$dob', '$gender', '$entryType', '$phoneNum', '$email', '$stateOrigin', '$passport')";
                $doTheQuery = $this->connect->query($insertApplicantData);
                if ($doTheQuery) {
                    $getIdQuery = "SELECT applicant_id FROM applicant where surname = '$surname' and first_name = '$firstname'";
                    $getId = $this->connect->query($getIdQuery);
                    $id = $getId->fetch_assoc()['applicant_id'];
                    // echo json_encode($id);
                    $examNum = 'ENT'.$id;
                    $examNumQuery = "UPDATE applicant SET exam_num = '$examNum' where applicant_id = '$id'";
                    $insertExamNum = $this->connect->query($examNumQuery);
                    echo json_encode(['response'=>"Applicant Saved Successfully", 'id'=> $id]);					
                }
                else{
                    echo "Error in Saving Data";
                }
            }
            else{
                echo "Kindly ensure all fields are filled. Thank you!";
            }
          }
          public function viewApplicant($applicantId)
          {
            $myQuery = "SELECT * FROM applicant where applicant_id = '$applicantId'";
            $fetchTheData = $this->connect->query($myQuery);
            echo json_encode($fetchTheData->fetch_assoc());
          }
          public function applicantLogin($examNum, $surname)
          {
              $SqlCheck = "SELECT applicant_id FROM applicant where exam_num = '$examNum' and surname = '$surname'";
              $checkApplicant = $this->connect->query($SqlCheck);
              if ($checkApplicant->num_rows > 0) {
                  echo json_encode(['msg'=>true, 'id'=>$checkApplicant->fetch_assoc()['applicant_id']]);
              } else {
                  echo json_encode(['msg'=>false]);
              }
              
          }
      }
?>