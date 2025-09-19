<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BasicDatabaseTest extends BaseController
{
    public function index()
    {
        echo "<h1>🧪 EduTrack LMS - Basic Database Test</h1>";
        echo "<p><strong>Testing core 3 tables: users, classrooms, classroom_users</strong></p>";
        
        $db = \Config\Database::connect();
        
        // Test basic tables
        $tables = ['users', 'classrooms', 'classroom_users'];
        
        echo "<h2>📊 Table Status:</h2>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; margin-bottom: 20px;'>";
        echo "<tr style='background-color: #f0f0f0;'><th>Table Name</th><th>Exists</th><th>Column Count</th><th>Structure Check</th></tr>";
        
        $allTablesExist = true;
        
        foreach ($tables as $table) {
            $exists = $db->tableExists($table);
            
            if ($exists) {
                // Get column info
                $fields = $db->getFieldData($table);
                $columnCount = count($fields);
                
                // Basic structure validation
                $structureOk = true;
                $structureMessage = "✅ OK";
                
                if ($table == 'users') {
                    // Check if users table has required columns
                    $requiredColumns = ['id', 'username', 'email', 'password', 'role'];
                    foreach ($requiredColumns as $col) {
                        $hasColumn = false;
                        foreach ($fields as $field) {
                            if ($field->name == $col) {
                                $hasColumn = true;
                                break;
                            }
                        }
                        if (!$hasColumn) {
                            $structureOk = false;
                            $structureMessage = "❌ Missing: $col";
                            break;
                        }
                    }
                }
                
                echo "<tr>";
                echo "<td><strong>$table</strong></td>";
                echo "<td style='color: green;'>✅ Yes</td>";
                echo "<td>$columnCount columns</td>";
                echo "<td>$structureMessage</td>";
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td><strong>$table</strong></td>";
                echo "<td style='color: red;'>❌ No</td>";
                echo "<td>-</td>";
                echo "<td style='color: red;'>❌ Missing</td>";
                echo "</tr>";
                $allTablesExist = false;
            }
        }
        
        echo "</table>";
        
        if (!$allTablesExist) {
            echo "<div style='background-color: #ffebee; padding: 15px; border-left: 4px solid #f44336; margin: 20px 0;'>";
            echo "<h3 style='color: #c62828; margin-top: 0;'>⚠️ Missing Tables Detected</h3>";
            echo "<p>Some tables are missing. Please run migrations:</p>";
            echo "<ol>";
            echo "<li>Open terminal in your project directory</li>";
            echo "<li>Run: <code>php spark migrate</code></li>";
            echo "<li>Refresh this page</li>";
            echo "</ol>";
            echo "</div>";
            echo "<p><a href='/'>← Back to Home</a></p>";
            return;
        }
        
        // Test basic functionality
        echo "<h2>🔧 Basic Functionality Test:</h2>";
        echo "<div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px;'>";
        
        $testResults = [];
        $testUser = null;
        $testClassroom = null;
        
        try {
            // Test 1: Insert user
            echo "<p><strong>Test 1:</strong> User Creation</p>";
            $userData = [
                'username' => 'test_user_' . time(),
                'email' => 'test' . time() . '@example.com',
                'first_name' => 'Test',
                'last_name' => 'User',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            
            $db->table('users')->insert($userData);
            $userId = $db->insertID();
            
            if ($userId) {
                echo "<p style='color: green; margin-left: 20px;'>✅ User creation: <strong>SUCCESS</strong> (ID: $userId)</p>";
                $testResults['user_insert'] = true;
                
                // Get the created user
                $testUser = $db->table('users')->where('id', $userId)->get()->getRow();
            } else {
                echo "<p style='color: red; margin-left: 20px;'>❌ User creation: <strong>FAILED</strong></p>";
                $testResults['user_insert'] = false;
            }
            
        } catch (\Exception $e) {
            echo "<p style='color: red; margin-left: 20px;'>❌ User creation error: " . $e->getMessage() . "</p>";
            $testResults['user_insert'] = false;
        }
        
        if ($testResults['user_insert'] && $testUser) {
            try {
                // Test 2: Create classroom
                echo "<p><strong>Test 2:</strong> Classroom Creation</p>";
                $classroomData = [
                    'classroom_name' => 'Test Classroom ' . time(),
                    'classroom_code' => 'TEST' . substr(time(), -4),
                    'description' => 'This is a test classroom for database validation',
                    'teacher_id' => $testUser->id,
                    'subject' => 'Test Subject',
                    'is_active' => 1,
                    'max_students' => 25,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                
                $db->table('classrooms')->insert($classroomData);
                $classroomId = $db->insertID();
                
                if ($classroomId) {
                    echo "<p style='color: green; margin-left: 20px;'>✅ Classroom creation: <strong>SUCCESS</strong> (ID: $classroomId, Code: {$classroomData['classroom_code']})</p>";
                    $testResults['classroom_insert'] = true;
                    
                    // Get the created classroom
                    $testClassroom = $db->table('classrooms')->where('id', $classroomId)->get()->getRow();
                } else {
                    echo "<p style='color: red; margin-left: 20px;'>❌ Classroom creation: <strong>FAILED</strong></p>";
                    $testResults['classroom_insert'] = false;
                }
                
            } catch (\Exception $e) {
                echo "<p style='color: red; margin-left: 20px;'>❌ Classroom creation error: " . $e->getMessage() . "</p>";
                $testResults['classroom_insert'] = false;
            }
        }
        
        if ($testResults['user_insert'] && $testResults['classroom_insert'] && $testUser && $testClassroom) {
            try {
                // Test 3: Enrollment (junction table)
                echo "<p><strong>Test 3:</strong> Student Enrollment</p>";
                $enrollmentData = [
                    'classroom_id' => $testClassroom->id,
                    'user_id' => $testUser->id,
                    'role' => 'student',
                    'joined_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                
                $db->table('classroom_users')->insert($enrollmentData);
                $enrollmentId = $db->insertID();
                
                if ($enrollmentId) {
                    echo "<p style='color: green; margin-left: 20px;'>✅ Student enrollment: <strong>SUCCESS</strong> (ID: $enrollmentId)</p>";
                    $testResults['enrollment'] = true;
                } else {
                    echo "<p style='color: red; margin-left: 20px;'>❌ Student enrollment: <strong>FAILED</strong></p>";
                    $testResults['enrollment'] = false;
                }
                
            } catch (\Exception $e) {
                echo "<p style='color: red; margin-left: 20px;'>❌ Enrollment error: " . $e->getMessage() . "</p>";
                $testResults['enrollment'] = false;
            }
        }
        
        // Test 4: Data Retrieval with JOIN
        if (isset($testResults['enrollment']) && $testResults['enrollment']) {
            try {
                echo "<p><strong>Test 4:</strong> Data Retrieval with JOIN</p>";
                $query = $db->query("
                    SELECT 
                        u.username, 
                        u.email, 
                        c.classroom_name, 
                        c.classroom_code,
                        cu.role,
                        cu.joined_at
                    FROM classroom_users cu
                    JOIN users u ON cu.user_id = u.id
                    JOIN classrooms c ON cu.classroom_id = c.id
                    WHERE u.id = ? AND c.id = ?
                ", [$testUser->id, $testClassroom->id]);
                
                $joinResult = $query->getRow();
                
                if ($joinResult) {
                    echo "<p style='color: green; margin-left: 20px;'>✅ JOIN query: <strong>SUCCESS</strong></p>";
                    echo "<p style='margin-left: 40px; background-color: #e8f5e8; padding: 10px; border-radius: 3px;'>";
                    echo "<strong>Retrieved:</strong> {$joinResult->username} enrolled in '{$joinResult->classroom_name}' ({$joinResult->classroom_code}) as {$joinResult->role}";
                    echo "</p>";
                    $testResults['join_query'] = true;
                } else {
                    echo "<p style='color: red; margin-left: 20px;'>❌ JOIN query: <strong>FAILED</strong></p>";
                    $testResults['join_query'] = false;
                }
                
            } catch (\Exception $e) {
                echo "<p style='color: red; margin-left: 20px;'>❌ JOIN query error: " . $e->getMessage() . "</p>";
                $testResults['join_query'] = false;
            }
        }
        
        echo "</div>";
        
        // Clean up test data
        echo "<h2>🧹 Cleanup Test Data:</h2>";
        try {
            if ($testUser && $testClassroom) {
                $db->table('classroom_users')->where('user_id', $testUser->id)->delete();
                $db->table('classrooms')->where('id', $testClassroom->id)->delete();
                $db->table('users')->where('id', $testUser->id)->delete();
                echo "<p style='color: green;'>✅ Test data cleanup: <strong>SUCCESS</strong></p>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: orange;'>⚠️ Cleanup note: " . $e->getMessage() . "</p>";
        }
        
        // Summary
        echo "<hr>";
        $passedTests = array_sum($testResults);
        $totalTests = count($testResults);
        
        if ($passedTests == $totalTests && $totalTests > 0) {
            echo "<h2 style='color: green;'>🎉 All Tests Passed! ($passedTests/$totalTests)</h2>";
            echo "<div style='background-color: #e8f5e8; padding: 15px; border-left: 4px solid #4caf50; margin: 20px 0;'>";
            echo "<h3 style='color: #2e7d32; margin-top: 0;'>✅ Database is Working Perfectly!</h3>";
            echo "<p><strong>Your core database structure is ready for:</strong></p>";
            echo "<ul>";
            echo "<li>✅ User management (registration, login)</li>";
            echo "<li>✅ Classroom creation and management</li>";
            echo "<li>✅ Student enrollment system</li>";
            echo "<li>✅ Ready to add assignments and assessments</li>";
            echo "</ul>";
            echo "<p><strong>Next steps:</strong> Add remaining tables (assignments, questions, submissions, notifications) and create sample data.</p>";
            echo "</div>";
        } else {
            echo "<h2 style='color: red;'>❌ Some Tests Failed ($passedTests/$totalTests)</h2>";
            echo "<p>Please check the errors above and fix the issues before continuing.</p>";
        }
        
        echo "<p><a href='/' style='color: blue;'>← Back to Home</a></p>";
    }
}