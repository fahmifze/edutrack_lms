<?php
// Temporary file: app/Controllers/DatabaseTest.php
// Delete this file after testing

namespace App\Controllers;

class DatabaseTest extends BaseController
{
    public function index()
    {
        // Test database connection
        $db = \Config\Database::connect();
        if ($db) {
            echo "<h1>✅ Database Connection Successful!</h1>";
            echo "<p><strong>Database Name:</strong> " . $db->getDatabase() . "</p>";
            echo "<p><strong>Host:</strong> " . $db->hostname . "</p>";
            echo "<p><strong>Driver:</strong> " . $db->DBDriver . "</p>";
            
            // Test query
            $query = $db->query("SELECT VERSION() as version");
            $result = $query->getRow();
            echo "<p><strong>MySQL Version:</strong> " . $result->version . "</p>";
            
            echo "<hr>";
            echo "<p>✅ Your EduTrack LMS database is ready!</p>";
            echo "<p><a href='/'>← Back to Home</a></p>";
        } else {
            echo "<h1>❌ Database Connection Failed!</h1>";
            echo "<p>Please check your .env configuration</p>";
        }
    }
}