<?php

namespace App\Models;

use CodeIgniter\Model;

class bimbinganModel extends Model
{
    // THESE LINES
    protected $table   = 'bimbingan';
    protected $protectFields = false;
    protected $allowedFields = [
        'teacher_id',
        'student_id',
        'ta_1',
        'ta_2',
        'bab_terakhir',
        'status_terakhir',
        'jml_bimbingan',
        
        'created_at',
        'updated_at',
    ];

	public function get($ID = false, $teacher_id = false, $user = [])
    {
        if ($ID) {
            return $this->db->table('bimbingan')
            ->where(['bimbingan.id' => $ID])
            ->select(
                '
                    bimbingan.*,
                    students.name as student_name,
                    students.nim as student_nim,
                    students.email as student_email,
                    teachers.name as teacher_name,
                    teachers.email as teacher_email,
                    teachers.npp as teacher_npp
                '
            )
            ->join('teachers', 'bimbingan.teacher_id = teachers.id')
            ->join('students', 'bimbingan.student_id = students.id')
            ->get()->getRowArray();
        } else if ($teacher_id) {
            return $this->db->table('bimbingan')
            ->where(['bimbingan.teacher_id' => $teacher_id])
            ->select(
                '
                    bimbingan.*,
                    students.name as student_name,
                    students.nim as student_nim,
                    students.email as student_email,
                    teachers.name as teacher_name,
                    teachers.email as teacher_email,
                    teachers.npp as teacher_npp
                '
            )
            ->join('teachers', 'bimbingan.teacher_id = teachers.id')
            ->join('students', 'bimbingan.student_id = students.id')
            ->get()->getResultArray();
        } else {
            $role_field = [
                '2' => 'teacher_id',
                '3' => 'student_id',
            ];
            $where = [];
            if(isset($user['role_id']) && isset($role_field[$user['role_id']])) {
                $field = $role_field[$user['role_id']];
                $where[$field] = $user[$field];
            }

            return $this->db->table('bimbingan')
            ->where($where)
            ->select(
                '
                    bimbingan.*,
                    students.name as student_name,
                    students.nim as student_nim,
                    students.email as student_email,
                    teachers.name as teacher_name,
                    teachers.email as teacher_email,
                    teachers.npp as teacher_npp
                '
            )
            ->join('teachers', 'bimbingan.teacher_id = teachers.id')
            ->join('students', 'bimbingan.student_id = students.id')
            ->get()->getResultArray();
        }
    }

    public function findData ($teacher_id, $student_id) 
    {
        return $this->db->table('bimbingan')
            ->where(['bimbingan.teacher_id' => $teacher_id, 'bimbingan.student_id' => $student_id])
            ->get()->getRowArray();
    }

	public function createData($data)
    {
        $model = new bimbinganModel();
        $model->insert([
            'teacher_id'     	    => $data['teacher_id'],
            'student_id'     	    => $data['student_id'],
            'ta_1'     	            => 'n',
            'ta_2'     	            => 'n',
            'bab_terakhir'     	    => 1,
            'status_terakhir'     	=> '',
            'jml_bimbingan'     	=> 0,

            'created_at'     	=> date('Y-m-d h:i:s'),
            'updated_at'     	=> date('Y-m-d h:i:s'),
        ]);
        
        return $model;
    }

    public function updateData($data)
    {
        $model = new bimbinganModel();
        $model->update(
            [
                'id' => $data['id']
            ], [
                'teacher_id'     	    => $data['teacher_id'],
                'student_id'     	    => $data['student_id'],
                'ta_1'     	            => $data['ta_1'],
                'ta_2'     	            => $data['ta_2'],
                'bab_terakhir'     	    => $data['bab_terakhir'],
                'status_terakhir'     	=> $data['status_terakhir'],
                'jml_bimbingan'     	=> $data['jml_bimbingan'],
                // 'created_at'     	=> date('Y-m-d h:i:s'),
                'updated_at'     	=> date('Y-m-d h:i:s'),
            ]
        );
        
        return $model;
    }
}
