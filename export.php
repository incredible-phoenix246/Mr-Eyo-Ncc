<?php
// DB credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'upresult');

// Create a database connection
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch data from the database (select specific columns)
$sql = "SELECT StudentName, StudentId, RollId, StudentEmail FROM tblstudents";
$result = $connection->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$connection->close();

// Create a CSV file
$csvFileName = 'exported_data.csv';
$csvFile = fopen($csvFileName, 'w');

// Define custom headers
$headers = array('Name', 'ID', 'Username', 'Email');

// Add CSV header (custom column names)
fputcsv($csvFile, $headers);

// Add data rows
if (!empty($data)) {
    foreach ($data as $row) {
        // Map database columns to custom headers
        $rowData = array(
            $row['StudentName'],
            $row['StudentId'],
            $row['RollId'],
            $row['StudentEmail']
        );

        fputcsv($csvFile, $rowData);
    }
}

fclose($csvFile);

// Set headers for download
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $csvFileName . '"');

// Output the file to the browser
readfile($csvFileName);
?>
