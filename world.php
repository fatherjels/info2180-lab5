<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $country = $_GET['country'];
        $lookup = $_GET['lookup'] ?? 'country';

        if ($lookup === 'cities') {
          
            $stmt = $conn->prepare(
                "SELECT cities.name AS city_name, cities.district, cities.population
                 FROM cities
                 JOIN countries ON cities.country_code = countries.code
                 WHERE countries.name LIKE :country"
            );
            $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                
                echo "<table border='1'>";
                echo "<thead>
                        <tr>
                            <th>Name</th>
                            <th>District</th>
                            <th>Population</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['population']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No cities found for \"$country\".</p>";
            }
        } else {
           
            $stmt = $conn->prepare(
                "SELECT name, continent, independence_year, head_of_state
                 FROM countries
                 WHERE name LIKE :country"
            );
            $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                
                echo "<table border='1'>";
                echo "<thead>
                        <tr>
                            <th>Name</th>
                            <th>Continent</th>
                            <th>Independence Year</th>
                            <th>Head of State</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No results found for \"$country\".</p>";
            }
        }
    } else {

        echo "<p>Please enter a country name to search.</p>";
    }
} catch (PDOException $e) {
    echo "<p>An error occurred while connecting to the database: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
