<?php

namespace App\Models;

use App\Models\UserModel;
use CodeIgniter\Model;

class MovementModel extends Model {
    
    protected $table = 'check_outin';

    protected $allowedFields = ['barcode', 'badge_number', 'status'];

    public function checkOut($barcode, $badgeNumber, $firstName = null, $lastName = null) {

        // TODO: Add safety checks

        if ($this->isNewUser($badgeNumber)) {
            $userModel = new UserModel();
            $userModel->insert([
                'badge_number' => $badgeNumber,
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);
        }

        $this->insert([
            'barcode' => $barcode,
            'badge_number' => $badgeNumber,
            'status' => 'out'
        ]);

    }

    public function checkIn($barcode) {

        // TODO: Add safety checks

        $badgeNumber = $this->getMostRecentBadgeNumber($barcode);

        $this->insert([
            'barcode' => $barcode,
            'badge_number' => $badgeNumber,
            'status' => 'in'
        ]);

    }

    public function getMostRecentBadgeNumber($barcode) {

        //TODO: Add safety checks

        $record = $this->getMostRecentRecord($barcode);

        if ($record) {
            return $record->badge_number;
        }

        return null;
    }

    public function getItemStatus($barcode) {

        $record = $this->getMostRecentRecord($barcode);

        if (!$record || $record->status === 'in') {
            // Either check-in and check-out records do not exist, so it is checked in,
            // Or most recent record states that the item was checked in

            return 'in';
        }

        // Records indicate item was last checked out
        return 'out';
    }

    private function getMostRecentRecord($barcode) {

        $sql = 'SELECT `check_outin`.`barcode`, `badge_number`, `status`, `check_outin`.`date` FROM `check_outin` INNER JOIN (SELECT `barcode`, MAX(`date`) AS `date` FROM `check_outin` GROUP BY `barcode`) A1 ON A1.`barcode`=`check_outin`.`barcode` AND A1.`date`=`check_outin`.`date` WHERE `check_outin`.`barcode`=:barcode:';
        $record = $this->db->query($sql, ['barcode' => $barcode])->getRow();

        return $record;
    }

    private function isNewUser($badgeNumber) {
        $userModel = new UserModel();
        return $userModel->find($badgeNumber) === null;
    }
}