<?php

namespace App\Services;


class CustomService
{
    public function full_address($row)
    {
        return $row->street . ' ' .  $row->barangay . ' ' . $row->city . ' ' . $row->province;
    }
    public function user_full_name($key){

        return $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . ' ' . $key->extension;

    }

    public function put_zeros($last_digits){

        $tracking_number = '';
        
        switch ($last_digits) {
            case $last_digits < 10:
                $tracking_number = '00'.$last_digits;
                break;
            case $last_digits < 100:
                $tracking_number = '0'.$last_digits;
                break;
            default:
                $tracking_number = $last_digits;
                break;
        }

        return $tracking_number;

    }
}
