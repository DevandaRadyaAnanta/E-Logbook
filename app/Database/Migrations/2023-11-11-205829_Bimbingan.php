<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bimbingan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'teacher_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
            'student_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
            'ta_1'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
            'ta_2'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
            'bab_terakhir'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
            'status_terakhir'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
            'jml_bimbingan'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
            'created_at' => [
                'type'           => 'datetime'
            ],
            'updated_at' => [
                'type'           => 'datetime'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bimbingan');
    }

    public function down()
    {
        $this->forge->dropTable('bimbingan');
    }
}
