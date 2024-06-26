<?php

	$inData = getRequestInfo();

	$id = $inData["ID"];
	$newFirstName = $inData["FirstName"];
	$newLastName = $inData["LastName"];
	$newEmail = $inData["Email"];
	$newPhone = $inData["Phone"];
    $favoriteStatus = $inData["Favorite"];

	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error)
	{
	    returnWithError($conn->connect_error);
	}
	else
	{
		$stmt = $conn->prepare("UPDATE Contacts SET FirstName = ?, LastName = ?, Email = ?, Phone = ?, Favorite = ? WHERE ID = ?");
		$stmt->bind_param("isssss", $id, $newFirstName, $newLastName, $newEmail, $newPhone, $favoriteStatus);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson($obj)
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError($err)
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}

?>
