<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\logBookModel;
use App\Models\UserModel;

class Home extends BaseController
{
	public function index()
	{
        $logBookModel = new logBookModel();
        $query = $this->db->query("
            select concat('Bab ', bimbingan.bab_terakhir) as bab, count(bimbingan.id) as jumlah
            from bimbingan
            group by bimbingan.bab_terakhir
        ");
        $chart = $query->getResultArray();

        $query = $this->db->query("
            select bimbingan.bab_terakhir as bab, bimbingan.status_terakhir, count(bimbingan.id) as jumlah
            from bimbingan
            group by bimbingan.bab_terakhir, bimbingan.status_terakhir
        ");
        $arrStatistik = $query->getResultArray();
        $statistik = [];
        foreach ($arrStatistik as $key => $item) {
            $keyName = $item['bab'].$item['status_terakhir'];
            $statistik[$keyName] = $item['jumlah'];
        }
        
        $userModel = new UserModel();
        $user = $userModel->getUser(username: session()->get('username'));
        // dd($user);
		$data = array_merge($this->data, [
			'title' => 'Dashboard Page',
            'chart'  => $chart,
            'statistik' => $statistik,
            'user' => $user
		]);
		return view('common/home', $data);
	}

    public function changePassword() 
    {
        $data = $this->request->getPost(null, FILTER_UNSAFE_RAW);

        $this->db->table('users')->update(
            [
                'password'		=> password_hash($data['inputPassword'], PASSWORD_DEFAULT),
                'change_password' => 0
            ], [
                'username'    => session()->get('username')
            ]
        );

        return redirect()->to(base_url('home'));
    }
}
