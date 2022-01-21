<?php
//signin và signup
$conn = mysqli_connect('localhost', 'tle', 'tle136', 'C354_tle');


function isUserValid($u, $p) 
{
    global $conn;
    
    $sql = "select * from `ForumUsers` where Username = '$u' and Password = '$p'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function doesUserExist($u)
{
    global $conn;
    
    $sql = "select Username from `ForumUsers` where Username = '$u'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function signUpNewUser($u, $p, $e)
{
    global $conn;
    
    $current_date = date("Ymd");
    $sql = "insert into `ForumUsers` values (null, '$u', '$p', '$e', $current_date)";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function postForums($u, $q){
    if(!existedForum($q)){
        global $conn;
        $sql = "select Id from `ForumUsers` where Username = '$u'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $userId = $row[0];
        $date = date("Ymd");
        $sql = "insert into `Forum` values (null, '$q', '$userId', '$date')";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
    else{
        return "Failed to insert forum.";
    }
}

function existedForum($q){
    global $conn;
    $sql = "SELECT * FROM `Forum` WHERE `Forums` = '$q'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function displayForums($q){
    global $conn;

    $sql = "select * from `Forum` where Forums = '$q'"; 
    $result = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)){
        array_push($data, $row);
    }
    return $data;
}

function editForums($id, $forums){
    global $conn;
    $sql = "update Forum set Forums ='$forums' where Id = '$id'"; 
    $result = mysqli_query($conn, $sql);
    return $result;
}

function editReplyForums($id_reply, $reply){
    global $conn;
    $sql = "update Reply set Reply ='$reply' where Id = '$id_reply'"; 
    $result = mysqli_query($conn, $sql);
    return $result;
}

function displayReplyEdit($q){
    global $conn;

    $sql = "select * from `Reply` where Reply = '$q'"; 
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)){
        array_push($data, $row);
    }
    return $data;
}

function deleteForums($id){
    global $conn;
    $sql = "delete from `Forum` where Id = '$id'"; 
    $result = mysqli_query($conn, $sql);
    // remove the reply when delete the main forum
    $sql = "delete from `Reply` where ForumId = '$id'"; 
    $result = mysqli_query($conn, $sql);
    return $result;
}

//deleteReplyForums
function deleteReplyForums($id){
    global $conn;
    $sql = "delete from `Reply` where Id = '$id'"; 
    $result = mysqli_query($conn, $sql);
    return $result;
}

//deleteAccount
function deleteAccount ($u) {
	global $conn;
    $sql = "select Id from `ForumUsers` where Username = '$u'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $userId = $row[0];
    // delete ForumUsers
	$sql = "delete from `ForumUsers` where Id = '$userId'";
	$result = mysqli_query($conn, $sql);
    // delete Forum
	$sql = "delete from `Forum` where UserId = '$userId'";
	$result = mysqli_query($conn, $sql);
    // delete Reply
	$sql = "delete from `Reply` where UserId = '$userId'";
	$result = mysqli_query($conn, $sql);
	return $result;
}

//searchQuestions
function searchQuestions($term) {
	    global $conn;
	    
	    $sql = "select * from Forum where Forums like '%$term%'";
	    $result = mysqli_query($conn, $sql);

	    $data = [];
	    $i = 0;
	    while ($row = mysqli_fetch_assoc($result)){
	    	$data[$i] = $row;
	    	$i++;
	    }
	    return $data;
}


function getUser($name){
    global $conn;
    $sql = "select * from `ForumUsers` where Username = '".$name."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row;
}

function getUsernameById($id){
    global $conn;
    $sql = "select Username from `ForumUsers` where Id = '".$id."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    if(isset($row[0])){
        return $row[0];
    }else{
        return '';
    }
}

function getAllForums($search = ''){
    global $conn;

    $sql = "select * from `Forum`"; 
    if($search != ''){
        $sql = "select * from `Forum` where Forums like '%$search%'";
    }
    $result = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)){
        array_push($data, $row);
    }
    return $data;
}

function insertReplyNew($id_forums, $reply){
    global $conn;
    $sql = "select Id from `ForumUsers` where Username = '".$_SESSION['username']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $userId = $row[0];
    $date = date("Ymd");
    $sql = "insert into `Reply` values (null, '$reply', '$userId', '$date', '$id_forums')"; 
    $result = mysqli_query($conn, $sql);
    $sql = "select * from `Reply` where UserId = '".$userId."' ORDER BY Id DESC";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row;
}

function getAllReply($id_forums = ''){
    global $conn;

    $sql = "select * from `Reply` where ForumId = '$id_forums'";
    $result = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)){
        array_push($data, $row);
    }
    return $data;
}
?>