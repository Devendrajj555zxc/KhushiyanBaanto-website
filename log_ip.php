<?php
// Get user IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Get date
$date = date("Y-m-d H:i:s");

// Use a public API to get city/country (optional)
$locationData = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
$location = $locationData && $locationData->status == "success" ? 
            $locationData->city . ", " . $locationData->country : "Unknown";

// Database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  http_response_code(500);
  die("Connection failed: " . $conn->connect_error);
}

// Insert IP data
$stmt = $conn->prepare("INSERT INTO visitor_log (ip_address, location, log_time) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $ip, $location, $date);
$stmt->execute();
$stmt->close();
$conn->close();

http_response_code(200);
?>



// Email notification settings
$to = "your-email@example.com";  // Replace with your email
$subject = "New Donation Visit on KhushiyanBaanto.com";
$message = "A user with IP: $ip from $location accessed the donation QR on $date.";
$headers = "From: notify@khushiyanbaanto.com";  // Replace with your domain mail if needed

// Send the email
mail($to, $subject, $message, $headers);



// Block known bots based on User-Agent
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$bots = ['bot', 'crawl', 'slurp', 'spider', 'mediapartners', 'Google', 'Bing'];

foreach ($bots as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        exit("Bot detected. Logging skipped.");
    }
}
