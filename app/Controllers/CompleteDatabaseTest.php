<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CompleteDatabaseTest extends BaseController
{
    public function index()
    {
        echo "<h1>🏗️ EduTrack LMS - Complete Database Structure Test</h1>";
        echo "<p><strong>Testing all 7 core tables for LMS functionality</strong></p>";
        
        $db = \Config\Database::connect();
        
        // All expected tables
        $tables = [
            'users' => 'User authentication and profiles',
            'classrooms' => 'Virtual classrooms for courses',
            'classroom_users' => 'Student-teacher enrollments',
            'assignments' => 'Quizzes, tests, and assignments',
            'questions' => 'MCQ and other question types',
            'submissions' => 'Student answers and grades',
            'notifications' => 'System notifications'
        ];
        
        echo "<h2>📊 Complete Table Status:</h2>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; margin-bottom: 20px; width: 100%;'>";
        echo "<tr style='background-color: #f0f0f0;'>";
        echo "<th>Table Name</th><th>Purpose</th><th>Exists</th><th>Columns</th><th>Records</th>";
        echo "</tr>";
        
        $allTablesExist = true;
        $tableStats = [];
        
        foreach ($tables as $table => $purpose) {
            $exists = $db->tableExists($table);
            
            if ($exists) {
                // Get column info
                $fields = $db->getFieldData($table);
                $columnCount = count($fields);
                
                // Get record count
                try {
                    $query = $db->query("SELECT COUNT(*) as count FROM `$table`");
                    $result = $query->getRow();
                    $recordCount = $result->count;
                } catch (\Exception $e) {
                    $recordCount = "Error";
                }
                
                echo "<tr>";
                echo "<td><strong>$table</strong></td>";
                echo "<td style='font-size: 0.9em; color: #666;'>$purpose</td>";
                echo "<td style='color: green;'>✅ Yes</td>";
                echo "<td>$columnCount</td>";
                echo "<td>$recordCount</td>";
                echo "</tr>";
                
                $tableStats[$table] = [
                    'exists' => true,
                    'columns' => $columnCount,
                    'records' => $recordCount
                ];
            } else {
                echo "<tr>";
                echo "<td><strong>$table</strong></td>";
                echo "<td style='font-size: 0.9em; color: #666;'>$purpose</td>";
                echo "<td style='color: red;'>❌ No</td>";
                echo "<td>-</td>";
                echo "<td>-</td>";
                echo "</tr>";
                $allTablesExist = false;
                $tableStats[$table] = ['exists' => false];
            }
        }
        
        echo "</table>";
        
        if (!$allTablesExist) {
            echo "<div style='background-color: #ffebee; padding: 15px; border-left: 4px solid #f44336; margin: 20px 0;'>";
            echo "<h3 style='color: #c62828; margin-top: 0;'>⚠️ Missing Tables Detected</h3>";
            echo "<p>Some tables are missing. Please run migrations:</p>";
            echo "<ol>";
            echo "<li>Run: <code>php spark migrate</code></li>";
            echo "<li>Refresh this page</li>";
            echo "</ol>";
            echo "</div>";
            echo "<p><a href='/'>← Back to Home</a></p>";
            return;
        }
        
        // Database relationship test
        echo "<h2>🔗 Database Relationships Test:</h2>";
        echo "<div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px;'>";
        
        try {
            // Test complex query with multiple JOINs
            $query = $db->query("
                SELECT 
                    COUNT(DISTINCT u.id) as total_users,
                    COUNT(DISTINCT c.id) as total_classrooms,
                    COUNT(DISTINCT cu.id) as total_enrollments,
                    COUNT(DISTINCT a.id) as total_assignments,
                    COUNT(DISTINCT q.id) as total_questions,
                    COUNT(DISTINCT s.id) as total_submissions,
                    COUNT(DISTINCT n.id) as total_notifications
                FROM users u
                LEFT JOIN classrooms c ON u.id = c.teacher_id
                LEFT JOIN classroom_users cu ON u.id = cu.user_id
                LEFT JOIN assignments a ON c.id = a.classroom_id
                LEFT JOIN questions q ON a.id = q.assignment_id
                LEFT JOIN submissions s ON a.id = s.assignment_id
                LEFT JOIN notifications n ON u.id = n.user_id
            ");
            
            $stats = $query->getRow();
            
            echo "<p><strong>✅ Database Relationships Test: SUCCESS</strong></p>";
            echo "<div style='margin-left: 20px; background-color: #e8f5e8; padding: 10px; border-radius: 3px;'>";
            echo "<p><strong>Complex JOIN Query Results:</strong></p>";
            echo "<ul style='margin: 10px 0;'>";
            echo "<li>👥 Total Users: {$stats->total_users}</li>";
            echo "<li>🏫 Total Classrooms: {$stats->total_classrooms}</li>";
            echo "<li>📝 Total Enrollments: {$stats->total_enrollments}</li>";
            echo "<li>📚 Total Assignments: {$stats->total_assignments}</li>";
            echo "<li>❓ Total Questions: {$stats->total_questions}</li>";
            echo "<li>📤 Total Submissions: {$stats->total_submissions}</li>";
            echo "<li>🔔 Total Notifications: {$stats->total_notifications}</li>";
            echo "</ul>";
            echo "</div>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Relationship test error: " . $e->getMessage() . "</p>";
        }
        
        echo "</div>";
        
        // Foreign key constraints test
        echo "<h2>🔑 Foreign Key Constraints Test:</h2>";
        echo "<div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px;'>";
        
        try {
            // Test foreign key constraints by checking referential integrity
            $constraintTests = [
                'classrooms.teacher_id → users.id' => "
                    SELECT COUNT(*) as invalid_refs 
                    FROM classrooms c 
                    LEFT JOIN users u ON c.teacher_id = u.id 
                    WHERE u.id IS NULL AND c.teacher_id IS NOT NULL
                ",
                'classroom_users.classroom_id → classrooms.id' => "
                    SELECT COUNT(*) as invalid_refs 
                    FROM classroom_users cu 
                    LEFT JOIN classrooms c ON cu.classroom_id = c.id 
                    WHERE c.id IS NULL
                ",
                'classroom_users.user_id → users.id' => "
                    SELECT COUNT(*) as invalid_refs 
                    FROM classroom_users cu 
                    LEFT JOIN users u ON cu.user_id = u.id 
                    WHERE u.id IS NULL
                ",
                'assignments.classroom_id → classrooms.id' => "
                    SELECT COUNT(*) as invalid_refs 
                    FROM assignments a 
                    LEFT JOIN classrooms c ON a.classroom_id = c.id 
                    WHERE c.id IS NULL
                ",
                'questions.assignment_id → assignments.id' => "
                    SELECT COUNT(*) as invalid_refs 
                    FROM questions q 
                    LEFT JOIN assignments a ON q.assignment_id = a.id 
                    WHERE a.id IS NULL
                ",
            ];
            
            $allConstraintsValid = true;
            foreach ($constraintTests as $constraint => $sql) {
                $result = $db->query($sql)->getRow();
                if ($result->invalid_refs == 0) {
                    echo "<p>✅ <strong>$constraint</strong>: Valid</p>";
                } else {
                    echo "<p>❌ <strong>$constraint</strong>: {$result->invalid_refs} invalid references</p>";
                    $allConstraintsValid = false;
                }
            }
            
            if ($allConstraintsValid) {
                echo "<p style='color: green; font-weight: bold;'>🎉 All foreign key constraints are valid!</p>";
            }
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Foreign key test error: " . $e->getMessage() . "</p>";
        }
        
        echo "</div>";
        
        // Migration status
        echo "<h2>📋 Migration Status:</h2>";
        try {
            $migrations = $db->table('migrations')->orderBy('version', 'ASC')->get()->getResult();
            
            if ($migrations) {
                echo "<table border='1' cellpadding='8' style='border-collapse: collapse; font-size: 0.9em;'>";
                echo "<tr style='background-color: #f0f0f0;'><th>Version</th><th>Migration File</th><th>Executed</th></tr>";
                
                foreach ($migrations as $migration) {
                    echo "<tr>";
                    echo "<td>{$migration->version}</td>";
                    echo "<td>{$migration->class}</td>";
                    echo "<td style='color: green;'>✅ Yes</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No migration records found.</p>";
            }
            
        } catch (\Exception $e) {
            echo "<p>Migration table not found or error: " . $e->getMessage() . "</p>";
        }
        
        // Summary
        echo "<hr>";
        
        if ($allTablesExist) {
            echo "<h2 style='color: green;'>🎉 Complete Database Structure Ready!</h2>";
            echo "<div style='background-color: #e8f5e8; padding: 20px; border-left: 4px solid #4caf50; margin: 20px 0;'>";
            echo "<h3 style='color: #2e7d32; margin-top: 0;'>✅ Full LMS Database Successfully Created!</h3>";
            echo "<p><strong>Your EduTrack LMS is ready for:</strong></p>";
            echo "<ul>";
            echo "<li>✅ User authentication and role management</li>";
            echo "<li>✅ Classroom creation and student enrollment</li>";
            echo "<li>✅ Assignment and quiz management</li>";
            echo "<li>✅ Question bank with MCQ support</li>";
            echo "<li>✅ Student submission and grading system</li>";
            echo "<li>✅ Notification system</li>";
            echo "</ul>";
            echo "<p><strong>Next steps:</strong></p>";
            echo "<ol>";
            echo "<li>🌱 Create sample data with seeder</li>";
            echo "<li>🔐 Build authentication pages (login, register)</li>";
            echo "<li>🏠 Create role-based dashboards</li>";
            echo "<li>📚 Implement classroom management features</li>";
            echo "</ol>";
            echo "</div>";
        }
        
        echo "<p><a href='/' style='color: blue;'>← Back to Home</a> | ";
        echo "<a href='/basic-test' style='color: blue;'>Basic Test</a></p>";
    }
}