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

    public function check_status($doc_status)
    {
        $status = '';

        switch ($doc_status) {
            case 'completed':
                $status = '<span class="badge p-2 bg-success">Completed</span>';
                break;
            case 'pending':
                $status = '<span class="badge p-2 bg-danger">Pending</span>';
                break;

            case 'cancelled':
                $status = '<span class="badge p-2 bg-warning">Canceled</span>';
                break;

            case 'outgoing':
                $status = '<span class="badge p-2 bg-secondary">Outgoing</span>';
                break;
            default:
                # code...
                break;
        }

        return $status;
    }

}
