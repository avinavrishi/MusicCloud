<?php
// Establish a connection to the MySQL database
include('db_connect.php');

// Get the search keywords from the client-side
$keywords = $_POST['keywords'];

// Prepare the SQL query to search for music based on keywords
// You would need to modify the query based on your specific schema
$query = "SELECT * FROM musicitems WHERE title LIKE '%$keywords%' OR artist LIKE '%$keywords%' OR genre LIKE '%$keywords%' OR album LIKE '%$keywords%'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch the search results as an array of associative arrays
    $searchResults = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $searchResults[] = $row;
    }

    // Return the search results as JSON to the client-side
    header('Content-Type: application/json');
    echo json_encode($searchResults);
} else {
    // Handle error if the query fails
    echo "Error occurred while searching for music: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
