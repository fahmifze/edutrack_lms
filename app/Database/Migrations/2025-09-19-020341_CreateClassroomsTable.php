<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClassroomsTable extends Migration
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
            'classroom_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'classroom_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'max_students' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 30,
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
        $this->forge->addUniqueKey('classroom_code');
        $this->forge->addKey('teacher_id');
        
        // Add foreign key
        $this->forge->addForeignKey('teacher_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        // Create table
        $this->forge->createTable('classrooms');
    }

    public function down()
    {
        $this->forge->dropTable('classrooms');
    }
}