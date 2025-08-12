<?php
// Include database connection file
include_once("config.php");

if(isset($_POST['update']))
{	
	// Retrieve record values
	$id = $_POST['id'];
	$name = $_POST['name'];
	$age = $_POST['age'];
	$email = $_POST['email'];	

	$nameErr = $ageErr = $emailErr = "";
	
	// Check for empty fields
	if(empty($name) || empty($age) || empty($email)) {	
		if(empty($name)) {
			$nameErr = "* required";
		}
		if(empty($age)) {
			$ageErr = "* required";
		}
		if(empty($email)) {
			$emailErr = "* required";
		}		
	} else {	
		// Execute UPDATE 
		$stmt = $pdo->prepare("UPDATE contacts SET name = ?, age = ?, email = ? WHERE id = ?");
		$stmt->execute([$name, $age, $email, $id]);

		// Redirect to home page (index.php)
		header("Location: index.php");
	}
}
else if (isset($_POST['cancel'])) {
	// Redirect to home page (index.php)
	header("Location: index.php");
}
?>
<?php
//class Contact

// Retrieve id value from querystring parameter
$id = $_GET['id'];

// Get contact by id
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$id]);
$arr = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$arr) {
    printf($arr);
    exit($arr);
}
else {
	//foreach($arr as $row)
	//{
		$name = $arr['name'];
		$age = $arr['age'];
		$email = $arr['email'];
	//}
}
?>
<html>
<head>	
	<title>Edit Contact</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<form name="form1" method="post" action="edit.php?id=<?= htmlspecialchars(isset($id) ? $id : "")?>">
		<table>
			<tr> 
				<td>Name</td>
                <td>
                    <input type="text" name="name" value="<?= htmlspecialchars(isset($name) ? $name : "")?>">
                    <span class="error"><?= htmlspecialchars(isset($nameErr) ? $nameErr : "")?></span>
                </td>
			</tr>
			<tr>
                <td>Age</td>
                <td>
                    <input type="text" name="age" value="<?= htmlspecialchars(isset($age) ? $age : "")?>">
                    <span class="error"><?= htmlspecialchars(isset($ageErr) ? $ageErr : "")?></span>
                </td>
			</tr>
			<tr>
                <td>Email</td>
                <td>
                    <input type="text" name="email" value="<?= htmlspecialchars(isset($email) ? $email : "")?>">
                    <span class="error"><?= htmlspecialchars(isset($emailErr) ? $emailErr : "")?></span>
                </td>
			</tr>
			<tr>
				<td>
					<input class="cancel" type="submit" name="cancel" value="Cancel">
				</td>
				<td>
					<input type="submit" name="update" value="Update">
					<input type="hidden" name="id" value=<?= htmlspecialchars(isset($id) ? $id : "")?>>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>