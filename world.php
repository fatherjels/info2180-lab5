<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the 'country' parameter exists in the GET request
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $country = $_GET['country'];

      
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            echo "<ul>";
            foreach ($results as $row) {
                echo "<li>" . htmlspecialchars($row['name']) . " is ruled by " . htmlspecialchars($row['head_of_state']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found for \"$country\".</p>";
        }
    } else {
        echo "<p>Please enter a country name to search.</p>";
    }
} catch (PDOException $e) {
    echo "<p>An error occurred while connecting to the database: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
