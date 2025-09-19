<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClassroomUsersTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['teacher', 'student'],
                'default' => 'student',
            ],
            'joined_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_active' => [
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
        $this->forge->addUniqueKey(['classroom_id', 'user_id']); // Prevent duplicate enrollments
        
        // Add foreign keys
        $this->forge->addForeignKey('classroom_id', 'classrooms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        // Create table
        $this->forge->createTable('classroom_users');
    }

    public function down()
    {
        $this->forge->dropTable('classroom_users');
    }
}