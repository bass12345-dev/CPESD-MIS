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
}
