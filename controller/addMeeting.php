<?php
session_start();
include 'connection_mysql.php';
$user_email = $_SESSION['userName'];
//inputTypeOfMeetin: "Sprint Retrospective", daterangeStart: "2016-05-18", inputMembersMeeting: Array[4], inputMeetingDescription: "fadfa", inputProjectName: "1"}
// read JSon input
$data_back = json_decode(file_get_contents('php://input'));

// set json string to php variables
$daterangeStart = $data_back->{"daterangeStart"};
$inputMeetingDescription = $data_back->{"inputMeetingDescription"};
$inputMembersMeeting = $data_back->{"inputMembersMeeting"};
$projectName = $data_back->{"inputProjectName"};
$inputTypeOfMeetin = $data_back->{"inputTypeOfMeetin"};

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction, User_email FROM Employee WHERE employeeEmail = '$user_email' AND Project_NameProject = '$projectName'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
	foreach ($inputMembersMeeting as $member) {
		echo $member;
		$mysqli->query("INSERT INTO Meeting(idMeeting, Project_NameProject, Project_User_email, Meeting_Description, Meeting_Date, MeetingMember) VALUES ('$inputTypeOfMeetin', '$projectName', '$user_email', '$inputMeetingDescription', '$daterangeStart', '$member')");
	}
	unset($member);
} else {
	//EMPLOYEE
	foreach ($inputMembersMeeting as $member) {
		echo $member;
		$admin = $rowVerifyEmployee['User_email'];
		$mysqli->query("INSERT INTO Meeting(idMeeting, Project_NameProject, Project_User_email, Meeting_Description, Meeting_Date, MeetingMember) VALUES ('$inputTypeOfMeetin', '$projectName', '$admin', '$inputMeetingDescription', '$daterangeStart', '$member')");
	}
	unset($member);
}
/*$json = array();
$bus = array(
	 			'inputTypeOfMeetin'=> $_POST['inputTypeOfMeetin'],
	 			'daterangeStart'=> $_POST['daterangeStart'],
	 			'inputMembersMeeting'=> $_POST['inputMembersMeeting'],
	 			'inputMeetingDescription'=> $_POST['inputMeetingDescription'],
	 			'inputProjectName'=> $_POST['inputProjectName']
	 			);
array_push($json, $bus);
echo urldecode(json_encode($json));*/
$mysqli->close();
?>
