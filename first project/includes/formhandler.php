<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    ob_start(); // Start output buffering

    $firstname = htmlspecialchars($_POST["firstName"]);
    $lastname = htmlspecialchars($_POST["lastName"]);
    $favoritepet = htmlspecialchars($_POST["pet"]);
    $password = htmlspecialchars($_POST["password"]);

    // Display the submitted data
    echo "<h3>The Data Submitted</h3><br>";
    echo $firstname . "<br>";
    echo $lastname . "<br>";
    echo $favoritepet . "<br>";
    echo $password;

    // Get the buffered output
    $output = ob_get_clean();

    // Redirect after all output is done
    header("Location: ../index.php");
    exit; // Stop script execution after redirection
} else {
    header("Location: ../index.php");
}
