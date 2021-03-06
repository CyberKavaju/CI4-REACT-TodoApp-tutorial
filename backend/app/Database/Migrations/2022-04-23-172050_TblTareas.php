<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblTareas extends Migration
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
            'titulo'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'descripcion'  => [
                'type'       => 'TEXT',
            ],
            'fecha_inicio' => [
                'type'       => 'DATE',
            ],
            'fecha_fin'    => [
                'type'       => 'DATE',
            ],
            'estado'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_tareas');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_tareas');
    }
}
