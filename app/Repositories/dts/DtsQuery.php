<?php

namespace App\Repositories\dts;

use Illuminate\Support\Facades\DB;

class DtsQuery
{

    //User Dashboard


    public static function added_document_date_now($conn,$now){

        $rows = DB::table('dts.documents as documents')
        ->leftjoin('cpesd_mis_users_db.users as users', 'users.user_id', '=', 'documents.u_id')
        ->leftJoin('dts.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
        ->select(   //Documents
                    'documents.created as created',
                    'documents.tracking_number as tracking_number', 
                    'documents.document_name as   document_name', 
                    'documents.document_id as document_id', 
                    'document_types.type_name as type_name', 
                    'documents.doc_status as doc_status', 
                    'documents.u_id as u_id', 
                    'documents.destination_type as destination_type',
                    //User
                    'users.first_name as first_name', 
                    'users.middle_name as middle_name', 
                    'users.last_name as last_name', 
                    'users.extension as extension', 
                    DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name"))
        ->whereDate('documents.created', '=', $now)
        ->orderBy('documents.document_id', 'desc')->get();

        return $rows;  
        

    }

     
     public static function count_forwarded_documents($conn,$user_id){
        $row = DB::connection($conn)->table('history as history')
        ->leftJoin('documents as documents', 'documents.tracking_number', '=', 'history.t_number')
        ->where('user1', session('user_id'))
        ->where('user2', $user_id)
        ->where('doc_status'  ,'!=', 'cancelled')
        ->where('received_status', NULL)
        ->where('status', 'torec')
        ->where('to_receiver', 'no')
        ->where('release_status',NULL )
        ->orderBy('tracking_number', 'desc');

        return $row;

    }

    public static function count_forwarded_documents_final($conn,$user_id){
        $row = DB::connection($conn)->table('history as history')
        ->leftJoin('documents as documents', 'documents.tracking_number', '=', 'history.t_number')
        ->where('user1', session('_id'))
        ->where('user2', $user_id)
        ->where('doc_status'  ,'!=', 'cancelled')
        ->where('received_status', NULL)
        ->where('status', 'torec')
        ->where('to_receiver', 'yes')
        ->where('release_status',NULL )
        ->orderBy('tracking_number', 'desc');

        return $row;

    }


    // User My Documents
    public static function get_my_documents($conn){
       
        $rows = DB::table('dts.documents as documents')
        ->leftjoin('cpesd_mis_users_db.users as users', 'users.user_id', '=', 'documents.u_id')
        ->leftJoin('dts.document_types as document_types', 'document_types.type_id', '=', 'documents.doc_type')
        ->leftJoin('dts.offices as offices', 'offices.office_id', '=', 'documents.origin')
        ->select(   'documents.created as d_created', 
                    'documents.doc_status as doc_status',
                    'documents.tracking_number as tracking_number', 
                    'documents.document_name as document_name', 
                    'documents.document_id as document_id', 
                    'documents.doc_type as doc_type', 
                    'documents.document_description as document_description', 
                    'documents.destination_type as destination_type',
                    'documents.origin as origin_id',
                    'document_types.type_name as type_name',
                    'users.first_name as first_name', 
                    'users.middle_name as middle_name', 
                    'users.last_name as last_name', 
                    'users.extension as extension',

                    'offices.office as origin',


                    DB::Raw("CONCAT(users.first_name, ' ', users.middle_name , ' ', users.last_name,' ',users.extension) as name")
                    )
        ->where('u_id', session('user_id'))
        ->orderBy('documents.document_id', 'desc')
        ->get();
        return $rows;
    }
    
}
