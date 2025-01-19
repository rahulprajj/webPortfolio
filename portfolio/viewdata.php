<?php
// Database connection
$host = 'localhost';
$dbname = 'contact_form_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch data from the database
try {
    $sql = "SELECT * FROM form_submissions ORDER BY submitted_at DESC";
    $stmt = $pdo->query($sql);
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Form Submissions</h2>";
    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Branding</th>
                <th>Ecommerce</th>
                <th>SEO</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>";
    foreach ($submissions as $submission) {
        echo "<tr>
                <td>" . $submission['name'] . "</td>
                <td>" . $submission['email'] . "</td>
                <td>" . $submission['website'] . "</td>
                <td>" . $submission['branding'] . "</td>
                <td>" . $submission['ecommerce'] . "</td>
                <td>" . $submission['seo'] . "</td>
                <td>" . $submission['message'] . "</td>
                <td>" . $submission['submitted_at'] . "</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
