<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Check for selected checkboxes
    $services = [];
    if (isset($_POST['website'])) {
        $services[] = "Websites";
    }
    if (isset($_POST['branding'])) {
        $services[] = "Branding";
    }
    if (isset($_POST['ecommerce'])) {
        $services[] = "Ecommerce";
    }
    if (isset($_POST['seo'])) {
        $services[] = "SEO";
    }
    $services_list = implode(", ", $services);

    // Recipient email address (your Gmail)
    $to = "rk0292852@gmail.com";

    // Email subject
    $subject = "New Contact Form Submission";

    // Email body
    $body = "You have received a new message from the contact form on your website.\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Services Interested: $services_list\n";
    $body .= "Message: $message\n";

    // Headers
    $headers = "From: $email" . "\r\n" .
        "Reply-To: $email" . "\r\n" .
        "Content-Type: text/plain; charset=UTF-8";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        // Display success message and redirect to a thank-you page or show a message
        echo "<script>alert('Your form has been submitted successfully!'); window.location.href = 'thank-you.html';</script>";
    } else {
        // Show error message if email fails
        echo "<script>alert('There was an issue submitting your form. Please try again later.'); window.location.href = 'contactform.php';</script>";
    }
}
