<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$host = "localhost";
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DBNAME'];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$org_id = $_SESSION['user_id'];

// API endpoint to retrieve strand application counts
if (isset($_GET['chart_data'])) {
    // Define the strands explicitly
    $strands = ['stem', 'humss', 'abm', 'gas', 'tvl'];
    $strand_counts = array_fill_keys($strands, 0); // Initialize counts to 0 for each strand

    // Now, get counts of applicants per strand
    $sql_counts = "SELECT sp.strand, COUNT(*) as count FROM applicants 
                   INNER JOIN student_profiles sp ON applicants.student_id = sp.user_id 
                   WHERE applicants.job_id IN (SELECT id FROM job_offers WHERE partner_id = '$org_id') 
                   GROUP BY sp.strand";
    $counts_result = mysqli_query($conn, $sql_counts);
    
    // Update counts based on the query results
    while ($row = mysqli_fetch_assoc($counts_result)) {
        // Only update counts for strands that exist in our predefined list
        if (in_array($row['strand'], $strands)) {
            $strand_counts[$row['strand']] = (int)$row['count']; // Ensure count is an integer
        }
    }

    // Return the counts as JSON
    echo json_encode($strand_counts);
    exit;
}

// Close the database connection
$conn->close();
?>