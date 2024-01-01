<?php

namespace App\Models;

use CodeIgniter\Model;

class logBookModel extends Model
{
    // THESE LINES
    protected $table   = 'log_book';
    protected $protectFields = false;
    protected $allowedFields = [
        'bimbingan_id',
        'tanggal',
        'uraian',
        'bab_terakhir',
        'status',
        'checklist',
        
        'created_at',
        'updated_at',
    ];

	public function get($ID = false, $bimbingan_id = false)
    {
        if ($ID) {
            return $this->db->table('log_book')
            ->where(['log_book.id' => $ID])
            ->get()->getRowArray();
        } if ($bimbingan_id) {
            return $this->db->table('log_book')
            ->where(['log_book.bimbingan_id' => $bimbingan_id])
            ->get()->getResultArray();
        } else {
            return $this->db->table('log_book')
            ->get()->getResultArray();
        }
    }

	public function createData($data)
    {
        $model = new logBookModel();
        $model->insert([
            'bimbingan_id'     	    => $data['bimbingan_id'],
            'tanggal'     	        => $data['tanggal'],
            'uraian'     	        => $data['uraian'],
            'bab_terakhir'     	    => $data['bab_terakhir'],
            'status'     	        => $data['status'],
            'checklist'     	    => $data['checklist'],

            'created_at'     	=> date('Y-m-d h:i:s'),
            'updated_at'     	=> date('Y-m-d h:i:s'),
        ]);

        $count = $this->db->table('log_book')
        ->where(['log_book.bimbingan_id' => $data['bimbingan_id']])
        ->select('count(id) as count')
        ->get()->getRowArray();

        $this->db->table('bimbingan')->update([
            'bab_terakhir'        => $data['bab_terakhir'],
            'status_terakhir'        => $data['status'],
            'jml_bimbingan' => $count['count']
        ], [
            'id' => $data['bimbingan_id']
        ]);
        
        return $model;
    }

    public function updateData($data)
    {
        $model = new logBookModel();
        $model->update(
            [
                'id' => $data['id']
            ], [
                // 'bimbingan_id'     	    => $data['bimbingan_id'],
                'tanggal'     	        => $data['tanggal'],
                'uraian'     	        => $data['uraian'],
                'bab_terakhir'     	    => $data['bab_terakhir'],
                'status'     	        => $data['status'],
                // 'checklist'     	    => $data['checklist'],
                // 'created_at'     	=> date('Y-m-d h:i:s'),
                'updated_at'     	=> date('Y-m-d h:i:s'),
            ]
        );

        $count = $this->db->table('log_book')
        ->where(['log_book.bimbingan_id' => $data['bimbingan_id']])
        ->select('count(id) as count')
        ->get()->getRowArray();

        $this->db->table('bimbingan')->update([
            'bab_terakhir'        => $data['bab_terakhir'],
            'status_terakhir'        => $data['status'],
            'jml_bimbingan' => $count['count']
        ], [
            'id' => $data['bimbingan_id']
        ]);
        
        return $model;
    }
}
