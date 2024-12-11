<!-- CREATE TABLE events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    label TEXT NOT NULL,
    font_size INTEGER NOT NULL,
    color TEXT NOT NULL
); -->

<?php
// Event Class
class Event {
    private $label;
    private $fontSize;
    private $color;

    // Constructor
    public function __construct($label, $fontSize, $color) {
        $this->label = $label;
        $this->fontSize = $fontSize;
        $this->color = $color;
    }

    // Destructor
    public function __destruct() {
        // Clean up if necessary
    }

    // Method to display event
    public function show_event() {
        echo "<p style='font-size: {$this->fontSize}px; color: {$this->color};'>{$this->label}</p>";
    }
}

// Database connection (SQLite)
try {
    $conn = new PDO('sqlite:events.db');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label = $_POST['label'];
    $fontSize = $_POST['font_size'];
    $color = $_POST['color'];

    // Validate inputs
    if (!empty($label) && is_numeric($fontSize) && !empty($color)) {
        try {
            // Insert event into the database
            $stmt = $conn->prepare("INSERT INTO events (label, font_size, color) VALUES (?, ?, ?)");
            $stmt->execute([$label, $fontSize, $color]);
            echo "<p>Event added successfully!</p>";
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Invalid input. Please try again.</p>";
    }
}

// Retrieve events from the database
try {
    $stmt = $conn->query("SELECT * FROM events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error retrieving events: " . $e->getMessage() . "</p>";
    $events = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Event Page</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <form action="" method="POST">
        <label for="label">Event Label:</label>
        <input type="text" id="label" name="label" required><br><br>
        
        <label for="font_size">Font Size (in px):</label>
        <input type="number" id="font_size" name="font_size" required><br><br>
        
        <label for="color">Font Color:</label>
        <input type="color" id="color" name="color" required><br><br>
        
        <button type="submit">Add Event</button>
    </form>

    <h2>Event List</h2>
    <?php
    if (!empty($events)) {
        foreach ($events as $eventData) {
            $event = new Event($eventData['label'], $eventData['font_size'], $eventData['color']);
            $event->show_event();
        }
    } else {
        echo "<p>No events to display.</p>";
    }
    ?>
</body>
</html>