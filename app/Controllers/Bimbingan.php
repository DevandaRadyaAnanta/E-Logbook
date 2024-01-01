<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\bimbinganModel;
use App\Models\logBookModel;
use App\Models\studentsModel;
use App\Models\TeacherModel;
use App\Models\UserModel;

class Bimbingan extends BaseController
{
    public $Model;

	function __construct()
	{
		$this->Model = new bimbinganModel();
	}

    public function index()
    {
        $studentsModel = new studentsModel();
        $TeacherModel = new TeacherModel();
        $userModel = new UserModel();
        $user = $userModel->getUser(username: session()->get('username'));
		$teacher_id = isset($_GET['filter_teacher_id']) ? $_GET['filter_teacher_id'] : false;

        $data = array_merge($this->data, [
            'title'         => 'Bimbingan Mahasiswa',
            'data'			=> $this->Model->get(teacher_id: $teacher_id, user:$user),
            'students'		=> $studentsModel->get(),
            'teachers'		=> $TeacherModel->get(),
            'user'			=> $user,
        ]);
		// dd($data);
        return view('bimbingan/bimbinganList', $data);
    }
    public function form()
    {
        $data = array_merge($this->data, [
            'title'         => 'Bimbingan Mahasiswa'
        ]);
        return view('bimbingan/bimbinganForm', $data);
    }

    public function create()
	{
        $data = $this->request->getPost(null, FILTER_UNSAFE_RAW);

        $check = $this->Model->findData($data['teacher_id'], $data['student_id']);
        if ($check) {
            session()->setFlashdata('notif_error', '<b>Mahasiswa sudah memiliki data bimbingan!</b>');
			return redirect()->to(base_url('bimbingan'));
        }

		$create = $this->Model->createData($data);

		if ($create) {
			session()->setFlashdata('notif_success', '<b>Successfully added new </b>');
			return redirect()->to(base_url('bimbingan'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new </b>');
			return redirect()->to(base_url('bimbingan'));
		}
	}

	public function update()
	{
		$update = $this->Model->updateData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($update) {
			session()->setFlashdata('notif_success', '<b>Successfully update </b>');
			return redirect()->to(base_url('bimbingan'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update </b>');
			return redirect()->to(base_url('bimbingan'));
		}
	}

	public function setUpdate($ID, $teacher_id)
	{
		$model = new bimbinganModel();
        $model->update([ 'id' => $ID ], $this->request->getGet());

		session()->setFlashdata('notif_success', '<b>Successfully update </b>');
		return redirect()->to(base_url('bimbingan' . '?filter_teacher_id=' . $teacher_id));
	}

	public function delete($ID)
	{
		if (!$ID) {
			return redirect()->to(base_url('bimbingan'));
		}
		$delete = $this->Model->delete($ID);
		
		if ($delete) {
			session()->setFlashdata('notif_success', '<b>Successfully delete </b>');
			return redirect()->to(base_url('bimbingan'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete </b>');
			return redirect()->to(base_url('bimbingan'));
		}
	}

    public function logBook ($bimbinganID) {
        $logBookModel = new logBookModel();
        $userModel = new UserModel();
        $user = $userModel->getUser(username: session()->get('username'));
        $data = array_merge($this->data, [
            'title'         => 'Log Book',
            'bimbingan_id'  => $bimbinganID,
            'log_books'			=> $logBookModel->get(bimbingan_id: $bimbinganID),
            'user'			=> $user,
        ]);
        return view('bimbingan/logBookList', $data);
    }

    public function logBookChecklist ($bimbinganID) {
		$logBook = $this->db->table('log_book')
				->select('*')
				->where(['log_book.id' => $bimbinganID])
				->get()->getRowArray();

        $this->db->table('log_book')->update([
            'checklist'        => 1
        ], [
            'id' => $bimbinganID
        ]);

        return redirect()->to(base_url("bimbingan/logBook/".$logBook['bimbingan_id']));
    }

    public function logBookCreate($bimbinganID)
	{
        $logBookModel = new logBookModel();
        $data = $this->request->getPost(null, FILTER_UNSAFE_RAW);
        $data['bimbingan_id'] = $bimbinganID;
        $data['checklist'] = 0;
		$create = $logBookModel->createData($data);
		if ($create) {
			session()->setFlashdata('notif_success', '<b>Successfully added new </b>');
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new </b>');
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		}
	}

	public function logBookUpdate($logBookID, $bimbinganID)
	{
        $logBookModel = new logBookModel();
        $data = $this->request->getPost(null, FILTER_UNSAFE_RAW);
        $data['bimbingan_id'] = $bimbinganID;
        // $data['checklist'] = 0;
		$create = $logBookModel->updateData($data);
		if ($create) {
			session()->setFlashdata('notif_success', '<b>Successfully added new </b>');
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new </b>');
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		}
	}

    public function logBookDelete($bimbinganID, $ID)
	{
		if (!$ID) {
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		}
        $logBookModel = new logBookModel();
		$delete = $logBookModel->delete($ID);
		
		if ($delete) {
			session()->setFlashdata('notif_success', '<b>Successfully delete </b>');
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete </b>');
			return redirect()->to(base_url("bimbingan/logBook/$bimbinganID"));
		}
	}
}
