<?php
include("../../config/db_conn.php");

// Show the role 
if (isset($_SESSION["role"])) {
    echo "You are logged in as: " . $_SESSION["role"] . "<br>";
} else {
    echo "No role set.<br>";
}

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
