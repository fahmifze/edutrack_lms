<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssignmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'classroom_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'instructions' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'assignment_type' => [
                'type' => 'ENUM',
                'constraint' => ['quiz', 'essay', 'file_upload', 'presentation'],
                'default' => 'quiz',
            ],
            'total_marks' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 100.00,
            ],
            'time_limit' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'Time limit in minutes',
            ],
            'due_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'allow_late_submission' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'is_published' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'show_results_immediately' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Add keys
        $this->forge->addKey('id', true);
        $this->forge->addKey('classroom_id');
        $this->forge->addKey('teacher_id');
        $this->forge->addKey('due_date');
        
        // Add foreign keys
        $this->forge->addForeignKey('classroom_id', 'classrooms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('teacher_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        // Create table
        $this->forge->createTable('assignments');
    }

    public function down()
    {
        $this->forge->dropTable('assignments');
    }
}