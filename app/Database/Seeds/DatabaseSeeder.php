<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create sample users
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@edutrack.com',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => 1,
                'email_verified' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'teacher1',
                'email' => 'teacher@edutrack.com',
                'first_name' => 'John',
                'last_name' => 'Teacher',
                'password' => password_hash('teacher123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'is_active' => 1,
                'email_verified' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'student1',
                'email' => 'student@edutrack.com',
                'first_name' => 'Jane',
                'last_name' => 'Student',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'email_verified' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert users
        $this->db->table('users')->insertBatch($users);

        // Create sample classrooms
        $classrooms = [
            [
                'classroom_name' => 'Introduction to Web Development',
                'classroom_code' => 'WEB101',
                'description' => 'Learn HTML, CSS, JavaScript and modern web frameworks',
                'teacher_id' => 2, // teacher1
                'subject' => 'Computer Science',
                'academic_year' => '2024/2025',
                'is_active' => 1,
                'max_students' => 30,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_name' => 'Database Management Systems',
                'classroom_code' => 'DB201',
                'description' => 'Advanced database concepts, SQL, and database design',
                'teacher_id' => 2, // teacher1
                'subject' => 'Computer Science',
                'academic_year' => '2024/2025',
                'is_active' => 1,
                'max_students' => 25,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('classrooms')->insertBatch($classrooms);

        // Enroll student in classrooms
        $enrollments = [
            [
                'classroom_id' => 1,
                'user_id' => 3, // student1
                'role' => 'student',
                'joined_at' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'classroom_id' => 2,
                'user_id' => 3, // student1
                'role' => 'student',
                'joined_at' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('classroom_users')->insertBatch($enrollments);

        // Create sample assignment
        $assignment = [
            'classroom_id' => 1,
            'teacher_id' => 2,
            'title' => 'HTML Basics Quiz',
            'description' => 'Test your knowledge of HTML fundamentals',
            'instructions' => 'Answer all questions. You have 30 minutes to complete this quiz.',
            'assignment_type' => 'quiz',
            'total_marks' => 20.00,
            'time_limit' => 30,
            'due_date' => date('Y-m-d H:i:s', strtotime('+1 week')),
            'allow_late_submission' => 0,
            'is_published' => 1,
            'show_results_immediately' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('assignments')->insert($assignment);

        // Create sample questions
        $questions = [
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'assignment_id' => 1,
                'question_text' => 'Which HTML tag is used to create a hyperlink?',
                'question_type' => 'mcq',
                'question_order' => 2,
                'marks' => 5.00,
                'option_a' => '<link>',
                'option_b' => '<a>',
                'option_c' => '<href>',
                'option_d' => '<url>',
                'correct_answer' => 'b',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('questions')->insertBatch($questions);

        echo "✅ Database seeded successfully!\n";
        echo "🎉 Sample data created:\n";
        echo "📧 Admin: admin@edutrack.com / admin123\n";
        echo "👨‍🏫 Teacher: teacher@edutrack.com / teacher123\n";
        echo "👨‍🎓 Student: student@edutrack.com / student123\n";
        echo "🏫 Sample classrooms and assignments created\n";
    }
}