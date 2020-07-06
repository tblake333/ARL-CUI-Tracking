<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ItemModel;
use CodeIgniter\RESTful\ResourceController;

class API extends ResourceController {

    protected $format = 'json';

    public function getUser() {
        $badge_number = $this->request->getVar('badge_number');
        if ($badge_number) {
            $userModel = new UserModel();
            return $this->respond($userModel->find($badge_number));
        } else {
            return redirect()->to('/');
        }
    }

    public function getItem() {
        $barcode = $this->request->getVar('barcode');
        if ($barcode) {
            $itemModel = new ItemModel();
            return $this->respond($itemModel->where('barcode', $barcode)->first());
        } else {
            return redirect()->to('/');
        }
    }
}