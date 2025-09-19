<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompleteLMSSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks temporarily
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        // Clear existing data in proper order (child tables first)
        echo "🗑️ Clearing existing data...\n";
        
        $this->db->table('notifications')->truncate();
        $this->db->table('submissions')->truncate();
        $this->db->table('questions')->truncate();
        $this->db->table('assignments')->truncate();
        $this->db->table('classroom_users')->truncate();
        $this->db->table('classrooms')->truncate();
        $this->db->table('users')->truncate();
        
        // Re-enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        
        echo "✅ Data cleared successfully...\n";
        
        // Create users
        $users = [
            // Admin
            [
                'username' => 'admin',
                'email' => 'admin@edutrack.com',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Teachers
            [
                'username' => 'john_teacher',
                'email' => 'john@edutrack.com',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'password' => password_hash('teacher123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'sarah_teacher',
                'email' => 'sarah@edutrack.com',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'password' => password_hash('teacher123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Students
            [
                'username' => 'alice_student',
                'email' => 'alice@edutrack.com',
                'first_name' => 'Alice',
                'last_name' => 'Brown',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'bob_student',
                'email' => 'bob@edutrack.com',
                'first_name' => 'Bob',
                'last_name' => 'Wilson',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'charlie_student',
                'email' => 'charlie@edutrack.com',
                'first_name' => 'Charlie',
                'last_name' => 'Davis',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('users')->insertBatch($users);
        echo "👥 Created 6 users (1 admin, 2 teachers, 3 students)...\n";

        // Create classrooms
        $classrooms = [
            [
                'classroom_name' => 'Introduction to Web Development',
                'classroom_code' => 'WEB101',
                'description' => 'Learn HTML, CSS, JavaScript and modern web frameworks. Perfect for beginners!',
                'teacher_id' => 2, // john_teacher
                'subject' => 'Computer Science',
                'is_active' => 1,
                'max_students' => 30,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_name' => 'Database Management Systems',
                'classroom_code' => 'DB201',
                'description' => 'Advanced database concepts, SQL queries, normalization, and database design.',
                'teacher_id' => 2, // john_teacher
                'subject' => 'Computer Science',
                'is_active' => 1,
                'max_students' => 25,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_name' => 'Data Structures and Algorithms',
                'classroom_code' => 'DSA301',
                'description' => 'Master fundamental data structures and algorithmic thinking.',
                'teacher_id' => 3, // sarah_teacher
                'subject' => 'Computer Science',
                'is_active' => 1,
                'max_students' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('classrooms')->insertBatch($classrooms);
        echo "🏫 Created 3 classrooms...\n";

        // Enroll students in classrooms
        $enrollments = [
            // Alice enrolls in all 3 classes
            ['classroom_id' => 1, 'user_id' => 4, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['classroom_id' => 2, 'user_id' => 4, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['classroom_id' => 3, 'user_id' => 4, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            
            // Bob enrolls in first 2 classes
            ['classroom_id' => 1, 'user_id' => 5, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['classroom_id' => 2, 'user_id' => 5, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            
            // Charlie enrolls in Web Dev and DSA
            ['classroom_id' => 1, 'user_id' => 6, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['classroom_id' => 3, 'user_id' => 6, 'role' => 'student', 'joined_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('classroom_users')->insertBatch($enrollments);
        echo "📝 Enrolled students in classrooms...\n";

        // Create assignments
        $assignments = [
            [
                'classroom_id' => 1,
                'teacher_id' => 2,
                'title' => 'HTML Fundamentals Quiz',
                'description' => 'Test your knowledge of HTML basics including tags, attributes, and document structure.',
                'instructions' => 'Answer all questions carefully. You have 30 minutes to complete this quiz. Each question is worth 5 points.',
                'assignment_type' => 'quiz',
                'total_marks' => 20.00,
                'time_limit' => 30,
                'due_date' => date('Y-m-d H:i:s', strtotime('+1 week')),
                'allow_late_submission' => 0,
                'is_published' => 1,
                'show_results_immediately' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_id' => 1,
                'teacher_id' => 2,
                'title' => 'CSS Styling Project',
                'description' => 'Create a responsive webpage using modern CSS techniques.',
                'instructions' => 'Design and implement a personal portfolio page using HTML and CSS. Include responsive design principles.',
                'assignment_type' => 'file_upload',
                'total_marks' => 50.00,
                'time_limit' => null,
                'due_date' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
                'allow_late_submission' => 1,
                'is_published' => 1,
                'show_results_immediately' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_id' => 2,
                'teacher_id' => 2,
                'title' => 'SQL Queries Assessment',
                'description' => 'Demonstrate your SQL skills with various query types.',
                'instructions' => 'Write SQL queries to solve the given problems. Focus on JOIN operations and subqueries.',
                'assignment_type' => 'quiz',
                'total_marks' => 30.00,
                'time_limit' => 45,
                'due_date' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'allow_late_submission' => 0,
                'is_published' => 1,
                'show_results_immediately' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_id' => 3,
                'teacher_id' => 3,
                'title' => 'Array Algorithms Quiz',
                'description' => 'Test your understanding of array manipulation algorithms.',
                'instructions' => 'Solve algorithmic problems related to arrays. Show your problem-solving approach.',
                'assignment_type' => 'quiz',
                'total_marks' => 25.00,
                'time_limit' => 40,
                'due_date' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'allow_late_submission' => 0,
                'is_published' => 1,
                'show_results_immediately' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('assignments')->insertBatch($assignments);
        echo "📚 Created 4 assignments...\n";

        // Create questions for quizzes
        $questions = [
            // HTML Quiz Questions (Assignment 1)
            [
                'assignment_id' => 1,
                'question_text' => 'What does HTML stand for?',
                'question_type' => 'mcq',
                'question_order' => 1,
                'marks' => 5.00,
                'option_a' => 'HyperText Markup Language',
                'option_b' => 'HighTech Modern Language',
                'option_c' => 'Home Tool Markup Language',
                'option_d' => 'Hyperlink and Text Markup Language',
                'correct_answer' => 'a',
                'explanation' => 'HTML stands for HyperText Markup Language, which is the standard markup language for creating web pages.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'assignment_id' => 1,
                'question_text' => 'Which HTML tag is used to create a hyperlink?',
                'question_type' => 'mcq',
                'question_order' => 2,
                'marks' => 5.00,
                'option_a' => '&lt;link&gt;',
                'option_b' => '&lt;a&gt;',
                'option_c' => '&lt;href&gt;',
                'option_d' => '&lt;url&gt;',
                'correct_answer' => 'b',
                'explanation' => 'The &lt;a&gt; tag with the href attribute is used to create hyperlinks in HTML.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'assignment_id' => 1,
                'question_text' => 'Which HTML tag is used for the largest heading?',
                'question_type' => 'mcq',
                'question_order' => 3,
                'marks' => 5.00,
                'option_a' => '&lt;h6&gt;',
                'option_b' => '&lt;h1&gt;',
                'option_c' => '&lt;header&gt;',
                'option_d' => '&lt;heading&gt;',
                'correct_answer' => 'b',
                'explanation' => 'The &lt;h1&gt; tag represents the largest heading in HTML, with &lt;h6&gt; being the smallest.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'assignment_id' => 1,
                'question_text' => 'What is the correct HTML element for inserting a line break?',
                'question_type' => 'mcq',
                'question_order' => 4,
                'marks' => 5.00,
                'option_a' => '&lt;break&gt;',
                'option_b' => '&lt;br&gt;',
                'option_c' => '&lt;lb&gt;',
                'option_d' => '&lt;newline&gt;',
                'correct_answer' => 'b',
                'explanation' => 'The &lt;br&gt; tag is used to insert a single line break in HTML.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // SQL Quiz Questions (Assignment 3)
            [
                'assignment_id' => 3,
                'question_text' => 'Which SQL statement is used to extract data from a database?',
                'question_type' => 'mcq',
                'question_order' => 1,
                'marks' => 10.00,
                'option_a' => 'OPEN',
                'option_b' => 'SELECT',
                'option_c' => 'GET',
                'option_d' => 'EXTRACT',
                'correct_answer' => 'b',
                'explanation' => 'SELECT is the SQL statement used to query and extract data from database tables.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'assignment_id' => 3,
                'question_text' => 'Which SQL JOIN returns all records when there is a match in either left or right table?',
                'question_type' => 'mcq',
                'question_order' => 2,
                'marks' => 10.00,
                'option_a' => 'INNER JOIN',
                'option_b' => 'LEFT JOIN',
                'option_c' => 'FULL OUTER JOIN',
                'option_d' => 'RIGHT JOIN',
                'correct_answer' => 'c',
                'explanation' => 'FULL OUTER JOIN returns all records when there is a match in either left or right table.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'assignment_id' => 3,
                'question_text' => 'What does the SQL WHERE clause do?',
                'question_type' => 'mcq',
                'question_order' => 3,
                'marks' => 10.00,
                'option_a' => 'Sorts the result',
                'option_b' => 'Filters records based on conditions',
                'option_c' => 'Groups similar records',
                'option_d' => 'Joins multiple tables',
                'correct_answer' => 'b',
                'explanation' => 'The WHERE clause is used to filter records and extract only those that fulfill a specified condition.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // DSA Quiz Questions (Assignment 4)
            [
                'assignment_id' => 4,
                'question_text' => 'What is the time complexity of accessing an element in an array by index?',
                'question_type' => 'mcq',
                'question_order' => 1,
                'marks' => 12.50,
                'option_a' => 'O(n)',
                'option_b' => 'O(log n)',
                'option_c' => 'O(1)',
                'option_d' => 'O(n²)',
                'correct_answer' => 'c',
                'explanation' => 'Array access by index is O(1) constant time because we can directly calculate the memory address.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('questions')->insertBatch($questions);
        echo "❓ Created 8 questions for quizzes...\n";

        // Create some sample submissions
        $submissions = [
            [
                'assignment_id' => 1, // HTML Quiz
                'student_id' => 4, // Alice
                'submission_data' => json_encode([
                    '1' => 'a', // Correct
                    '2' => 'b', // Correct
                    '3' => 'b', // Correct
                    '4' => 'a'  // Incorrect
                ]),
                'submitted_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'is_late' => 0,
                'time_taken' => 18,
                'marks_obtained' => 15.00,
                'percentage' => 75.00,
                'feedback' => 'Good understanding of HTML basics. Review line break elements.',
                'graded_by' => 2, // john_teacher
                'graded_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'status' => 'graded',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'assignment_id' => 1, // HTML Quiz
                'student_id' => 5, // Bob
                'submission_data' => json_encode([
                    '1' => 'a', // Correct
                    '2' => 'b', // Correct
                    '3' => 'c', // Incorrect
                    '4' => 'b'  // Correct
                ]),
                'submitted_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'is_late' => 0,
                'time_taken' => 25,
                'marks_obtained' => 15.00,
                'percentage' => 75.00,
                'feedback' => 'Well done! Remember that h1 is the largest heading tag.',
                'graded_by' => 2, // john_teacher
                'graded_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'status' => 'graded',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'assignment_id' => 3, // SQL Quiz
                'student_id' => 4, // Alice
                'submission_data' => json_encode([
                    '1' => 'b', // Correct
                    '2' => 'c', // Correct
                    '3' => 'b'  // Correct
                ]),
                'submitted_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'is_late' => 0,
                'time_taken' => 35,
                'marks_obtained' => 30.00,
                'percentage' => 100.00,
                'feedback' => 'Excellent work! Perfect understanding of SQL concepts.',
                'graded_by' => 2, // john_teacher
                'graded_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'status' => 'graded',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ]
        ];

        $this->db->table('submissions')->insertBatch($submissions);
        echo "📤 Created 3 sample submissions...\n";

        // Create notifications
        $notifications = [
            [
                'user_id' => 4, // Alice
                'title' => 'Welcome to EduTrack LMS!',
                'message' => 'Welcome to our learning platform! You have been enrolled in 3 courses. Check your dashboard to get started.',
                'notification_type' => 'system',
                'related_id' => null,
                'related_type' => null,
                'is_read' => 0,
                'is_email_sent' => 1,
                'priority' => 'medium',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'user_id' => 4, // Alice
                'title' => 'New Assignment: HTML Fundamentals Quiz',
                'message' => 'A new quiz has been assigned in your Web Development course. Due date: ' . date('M j, Y', strtotime('+1 week')),
                'notification_type' => 'assignment',
                'related_id' => 1,
                'related_type' => 'assignment',
                'is_read' => 1,
                'is_email_sent' => 1,
                'priority' => 'high',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 week')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'user_id' => 4, // Alice
                'title' => 'Quiz Graded: HTML Fundamentals',
                'message' => 'Your HTML Fundamentals Quiz has been graded. Score: 15/20 (75%). Great job!',
                'notification_type' => 'grade',
                'related_id' => 1,
                'related_type' => 'submission',
                'is_read' => 0,
                'is_email_sent' => 1,
                'priority' => 'medium',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'user_id' => 5, // Bob
                'title' => 'Welcome to EduTrack LMS!',
                'message' => 'Welcome to our learning platform! You have been enrolled in 2 courses. Good luck with your studies!',
                'notification_type' => 'system',
                'related_id' => null,
                'related_type' => null,
                'is_read' => 1,
                'is_email_sent' => 1,
                'priority' => 'medium',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'user_id' => 6, // Charlie
                'title' => 'Assignment Reminder: CSS Styling Project',
                'message' => 'Don\'t forget about your CSS project! Due in 2 weeks. Start early for best results.',
                'notification_type' => 'reminder',
                'related_id' => 2,
                'related_type' => 'assignment',
                'is_read' => 0,
                'is_email_sent' => 0,
                'priority' => 'low',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ]
        ];

        $this->db->table('notifications')->insertBatch($notifications);
        echo "🔔 Created 5 notifications...\n";

        echo "\n";
        echo "🎉 ===============================================\n";
        echo "✅ COMPLETE LMS SAMPLE DATA CREATED SUCCESSFULLY!\n";
        echo "=================================================\n";
        echo "\n";
        echo "📊 Data Summary:\n";
        echo "👥 Users: 6 (1 admin, 2 teachers, 3 students)\n";
        echo "🏫 Classrooms: 3\n";
        echo "📝 Enrollments: 7\n";
        echo "📚 Assignments: 4\n";
        echo "❓ Questions: 8\n";
        echo "📤 Submissions: 3\n";
        echo "🔔 Notifications: 5\n";
        echo "\n";
        echo "🔐 Login Credentials:\n";
        echo "📧 Admin: admin@edutrack.com / admin123\n";
        echo "👨‍🏫 Teacher 1: john@edutrack.com / teacher123\n";
        echo "👨‍🏫 Teacher 2: sarah@edutrack.com / teacher123\n";
        echo "👨‍🎓 Student 1: alice@edutrack.com / student123\n";
        echo "👨‍🎓 Student 2: bob@edutrack.com / student123\n";
        echo "👨‍🎓 Student 3: charlie@edutrack.com / student123\n";
        echo "\n";
        echo "🧪 Test your data at: http://localhost:8080/complete-test\n";
        echo "🚀 System status at: http://localhost:8080/system-status\n";
        echo "\n";
    }
}