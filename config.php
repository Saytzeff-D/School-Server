<?php
	require_once 'schoolIndex.php';
    $_POST = json_decode(file_get_contents('php://input'));

	if ($_FILES) {
		$target_dir = "C:\Users\DELL\Desktop\Vue Class\schoolApp\src\assets\/";
		$target_file = $target_dir . $_FILES['passport']['name'];
		$checkUpload = move_uploaded_file($_FILES['passport']['tmp_name'], $target_file);
		if ($checkUpload) {
			echo 'Uploaded';
		} else {
			echo 'File Error';
		}
		
	}
	else {
		if ($_POST->type == 'newApplication') {
			$surname = $_POST->surname;
			$firstname = $_POST->firstName;
			$middleName = $_POST->middleName;
			$dob = $_POST->DOB;
			$gender = $_POST->gender;
			$entryType = $_POST->entryType;
			$phoneNum = $_POST->phoneNumber;
			$email = $_POST->emailAddress;
			$stateOrigin = $_POST->stateOfOrigin;
			$passport = $_POST->passport;
			$apply = new Application;
			$apply->saveApplicant($surname, $firstname, $middleName, $dob, $gender, $entryType, $phoneNum, $email, $stateOrigin, $passport);
		}
		elseif ($_POST->type == 'applicantPage') {
			$applicantId = $_POST->id;
			$applicant = new Application;
			$applicant->viewApplicant($applicantId);
		}
		elseif ($_POST->type == 'applicantLogin') {
			$examNum = $_POST->examNum;
			$surname = $_POST->surname;
			$login =  new Application;
			$login->applicantLogin($examNum, $surname);
		}
		else{
			echo "Post Error";
		}
	}
?>