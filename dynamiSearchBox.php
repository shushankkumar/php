<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Search</title>
    <script>
        function searchRecords(query) {
            if (query.length === 0) {
                document.getElementById('results').innerHTML = '';
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('results').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'search.php?q=' + encodeURIComponent(query), true);
            xhr.send();
        }
    </script>
</head>
<body>s
    <h1>Dynamic Search Box</h1>
    <input type="text" onkeyup="searchRecords(this.value)" placeholder="Search for names...">
    <div id="results"></div>
</body>
</html>

// searchRecords
<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'dynamic_search';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Retrieve query parameter
$query = isset($_GET['q']) ? $_GET['q'] : '';

if ($query !== '') {
    $stmt = $conn->prepare('SELECT name FROM records WHERE name LIKE ? LIMIT 10');
    $searchTerm = "%$query%";
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<p>' . htmlspecialchars($row['name']) . '</p>';
        }
    } else {
        echo '<p>No results found</p>';
    }

    $stmt->close();
}

$conn-> close();
?>
