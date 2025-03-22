<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/config.php';

(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();

// Check if user_id exists in the session
$user_id = $_SESSION['user_id'] ?? null;
$document_name = $_GET['document_name'] ?? '';

if (empty($document_name) || is_null($user_id)) {
    echo "Invalid request.";
    exit;
}


$sql = "SELECT document_url FROM uploaded_documents WHERE user_id = :user_id AND document_name = :document_name";
$stmt = $pdo->prepare($sql);


$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':document_name', $document_name, PDO::PARAM_STR);
$stmt->execute();

$document_url = $stmt->fetchColumn();

if ($document_url) {
    $file_path = '/Account/Student/documents/' . basename($document_url);
    $full_path = $_SERVER['DOCUMENT_ROOT'] . $file_path;
    if (!file_exists($full_path)) {
        echo "File not found.";
        exit;
    }
} else {
    echo "No document found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        iframe {
            width: 100%;
            height: 600px;
            border: none;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Document Viewer</h1>
    <?php if ($document_url): ?>
        <iframe src="<?php echo htmlspecialchars($file_path); ?>"></iframe>
    <?php else: ?>
        <p class="error">No document found to display.</p>
    <?php endif; ?>
</body>

</html>