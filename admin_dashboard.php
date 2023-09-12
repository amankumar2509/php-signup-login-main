<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style>
        /* Additional CSS for the logout button */
        #logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #d9534f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px;
        }

        #logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div id="header">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>

    <script>
        // JavaScript function to log out the admin
        function logout() {
            // You can add a confirmation dialog here if needed
            window.location.href = "logout.php";
        }
    </script>

    <!-- Logout button positioned using CSS -->
    <button id="logout-btn" onclick="logout()">Logout</button>
</body>
</html>

<?php
     if(isset($_SESSION["user_type!==1"])){
         header("login.php");
         exit;
     }
    // session_start();
    $mysqli = require __DIR__ . "/database.php";
    
    // Fetch user information for admin users (user_type = 1)
    $sql = "SELECT id, name, email, status FROM user WHERE user_type='0'";
    $result = $mysqli->query($sql);
    
    
    // Check for errors or empty results
    if ($result === false || $result->num_rows == 0) {
        echo "No  users found.";
    } else {
        // Display user information in a table
        echo "<table border='1'>";
        echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
             </tr>";
    
        // ...
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            if($row["status"] == 0){//1 enable 0 disable
            echo '<td><p><a style="text-decoration:none;" href="status.php?id='.$row['id'].'&status=1">Enable</a></p></td>';
            }
            else{
            echo '<td><p><a style="text-decoration:none;" href="status.php?id='.$row['id'].'&status=0">Disable</a></p></td>';
            }
            echo "</tr>";
        }
        // ...

    
        echo "</table>";
    }
    
    // Close the database connection
    $mysqli->close();
 ?>