<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionsTable extends Migration
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
            'assignment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'question_text' => [
                'type' => 'LONGTEXT',
            ],
            'question_type' => [
                'type' => 'ENUM',
                'constraint' => ['mcq', 'short_answer', 'long_answer', 'true_false'],
                'default' => 'mcq',
            ],
            'question_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
            ],
            'marks' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 1.00,
            ],
            'option_a' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'option_b' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'option_c' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'option_d' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'correct_answer' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'explanation' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('assignment_id');
        $this->forge->addKey(['assignment_id', 'question_order']);
        
        // Add foreign key
        $this->forge->addForeignKey('assignment_id', 'assignments', 'id', 'CASCADE', 'CASCADE');
        
        // Create table
        $this->forge->createTable('questions');
    }

    public function down()
    {
        $this->forge->dropTable('questions');
    }
}