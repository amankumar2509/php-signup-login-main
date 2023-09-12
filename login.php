<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $email = $mysqli->real_escape_string($_POST["email"]);
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $email);
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if ($user["status"] == 0) {
            // User is disabled; set invalid flag
            $is_invalid = true;
        } elseif (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            
            if ($user["user_type"] == "1") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php"); 
            }
            exit;
        } else {
            // Password is incorrect; set invalid flag
            $is_invalid = true;
        }
    } else {
        // User not found; set invalid flag
        $is_invalid = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    
    
    <h1>Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login or user is disabled</em>
    <?php endif; ?>
    
    <form method="post">
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        </div>
        
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        
        <button class="submit-button">Log in</button>
    </form>
    
</body>
</html>
