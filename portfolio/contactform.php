<?php
// Database connection
$host = 'localhost';
$dbname = 'contact_form_db';
$username = 'root';  // Change this to your database username
$password = '';  // Change this to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data and apply conditional logic for checkboxes
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $website = isset($_POST['website']) ? 'Yes' : 'No';
    $branding = isset($_POST['branding']) ? 'Yes' : 'No';
    $ecommerce = isset($_POST['ecommerce']) ? 'Yes' : 'No';
    $seo = isset($_POST['seo']) ? 'Yes' : 'No';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Insert form data into the database
    try {
        $sql = "INSERT INTO form_submissions (name, email, website, branding, ecommerce, seo, message) 
                VALUES (:name, :email, :website, :branding, :ecommerce, :seo, :message)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':branding', $branding);
        $stmt->bindParam(':ecommerce', $ecommerce);
        $stmt->bindParam(':seo', $seo);
        $stmt->bindParam(':message', $message);

        // Execute the query
        $stmt->execute();

        // Send an email to your Gmail address
        $to = "rk0292852@gmail.com"; // Replace with your own Gmail address
        $subject = "You have received a new message from the contact form on your website.\n\n";
        $email_message = "Name: $name\nEmail: $email\n\n";
        $email_message .= "Website: $website\nBranding: $branding\nEcommerce: $ecommerce\nSEO: $seo\n\n";
        $email_message .= "Message: \n$message";

        $headers = "From: rk0292852@gmail.com"; // Replace with a valid email address

        // Send the email
        mail($to, $subject, $email_message, $headers);

        // Display a Thank You message with JavaScript
        echo "<script type='text/javascript'>
                alert('Thank you for your submission!');
                window.location.href = 'thank_you_page.php'; // Redirect to a thank you page or stay on the same page
              </script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
