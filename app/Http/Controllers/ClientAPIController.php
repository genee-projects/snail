<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientAPIController extends Controller
{
    public function index()
    {
        $Clients = Client::all();

        return response()->json($Clients);
    }

    public function refreshLatestBackupTime(Request $request)
    {
        try {
            $id = $request->input('id');

            if (!$id) {
                throw new Exception;
            }
            $Client = Client::find($id);

            if (!$Client->id) {
                throw new Exception;
            }
            
            $Client->refreshLatestBackupTime();

            $data = [
                'id'=> $Client->id,
                'latest_backup_time'=> $Client->latest_backup_time,
            ];
        } catch (Exception $e) {
            $data = [
                'error'=> true
            ];
        }

        return response()->json($data);
    }
}
