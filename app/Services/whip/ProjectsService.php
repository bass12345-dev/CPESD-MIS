<?php

namespace App\Services\whip;

use App\Repositories\CustomRepository;
use Carbon\Carbon;

class ProjectsService
{
    
    protected $conn;
    protected $customRepository;
    protected $projects_table;
    public function __construct(CustomRepository $customRepository){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->projects_table       = 'projects';
    }
    

    //REGISTER PROJECT
    public function registerProj(array $item)
    {

        $items = array(
            'contractor_id'         => $item['contractor_id'],
            'project_title'         => $item['project_title'],
            'project_cost'          => $item['project_cost'],
            'street'                => $item['street'],
            'barangay'              => $item['barangay'],
            'project_status'        => 'ongoing',
            'date_started'          => $item['date_started'],
            'project_nature_id'     => $item['project_nature_id'],
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),
            
        );
        $user = $this->customRepository->insert_item($this->conn,$this->projects_table,$items);
        return $user;
    }



    
}