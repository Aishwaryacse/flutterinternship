<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "library_management";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST["name"];
$username = $_POST["username"];
$password = $_POST["password"];
$registerNo = $_POST["register-no"];
$department = $_POST["department"];

// Insert the data into the database
$sql = "INSERT INTO students (name, username, password, register_no, department) VALUES ('$name', '$username', '$password', '$registerNo', '$department')";

if ($conn->query($sql) === TRUE) {
  $message = "Registration successful! You can now sign up.";
  $messageColor = "green";
} else {
  $message = "Error: " . $sql . "<br>" . $conn->error;
  $messageColor = "red";
}

// Retrieve the inserted data from the database
$retrieveSql = "SELECT * FROM students WHERE id = LAST_INSERT_ID()";
$result = $conn->query($retrieveSql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $insertedData = $row;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Staff Registration</title>
  <!-- CSS styles -->
  <style>
    body {
      background-color: #2a52be;
      text-align: center;
      color: white;
      font-family: Arial, sans-serif;
    }
    
    h1 {
      font-size: 32px;
      margin-top: 200px;
    }
    
    .form-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .form-container h2 {
      text-align: center;
    }
    
    .message-container {
      margin-top: 20px;
      text-align: center;
      padding: 10px;
      border-radius: 5px;
    }
    
    .message-container.green {
      background-color: #4CAF50;
    }
    
    .message-container.red {
      background-color: #FF0000;
    }
    
    .data-container {
      margin-top: 20px;
      text-align: left;
    }
  </style>
</head>
<body>
  <h1>Knowledge is Free at Library</h1>
  
  <div class="form-container">
    <h2>Staff Registration</h2>
    <div id="message-container" class="message-container <?php echo $messageColor; ?>"><?php echo $message; ?></div>
    
    <?php if (isset($insertedData)) : ?>
      <div class="data-container">
        <h3>Inserted Data:</h3>
        <p><strong>Name:</strong> <?php echo $insertedData['name']; ?></p>
        <p><strong>Username:</strong> <?php echo $insertedData['username']; ?></p>
        <p><strong>Register No:</strong> <?php echo $insertedData['register_no']; ?></p>
        <p><strong>Department:</strong> <?php echo $insertedData['department']; ?></p>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
