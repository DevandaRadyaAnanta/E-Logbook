<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogBook extends Migration
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
            'bimbingan_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
            'tanggal'          => [
				'type'           => 'date',
			],
            'uraian'       => [
				'type'       => 'TEXT',
			],
            'bab_terakhir'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
            'status'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
            'checklist'          => [
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
        $this->forge->createTable('log_book');
    }

    public function down()
    {
        $this->forge->dropTable('log_book');
    }
}
