<?php
declare(strict_types=1);

header("Content-Type: application/json; charset=UTF-8");

// Load dependencies (using flat root directory paths)
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/Lead.php';
require_once __DIR__ . '/IngestionService.php';
require_once __DIR__ . '/ScoringService.php';
require_once __DIR__ . '/RoutingService.php';

use App\Models\Lead;
use App\Services\IngestionService;
use App\Services\ScoringService;
use App\Services\RoutingService;

// 1. Only allow POST requests
// If accessed directly in browser (GET request), show a submit form
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header("Content-Type: text/html; charset=UTF-8");
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>Lead Submission</title></head>
    <body style="font-family: sans-serif; padding: 20px;">
        <h2>Submit Lead Test</h2>
        <form method="POST" action="ingest.php" style="display: flex; flex-direction: column; width: 300px; gap: 10px;">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number">
            <input type="text" name="company" placeholder="Company Name">
            <input type="hidden" name="source" value="DIRECT_FORM">
            <button type="submit">Submit Lead</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}

// 2. Dual Input Handler: Parse JSON body first, fallback to standard $_POST
$rawBody = file_get_contents('php://input');
$input = json_decode($rawBody, true);

if (!is_array($input) || empty($input)) {
    // If JSON decoding failed or body was empty, use standard form data ($_POST)
    $input = $_POST;
}

// 3. Validate required fields
if (empty($input['email'])) {
    http_response_code(400);
    echo json_encode([
        "error" => "Missing required field: 'email' is mandatory."
    ]);
    exit;
}

