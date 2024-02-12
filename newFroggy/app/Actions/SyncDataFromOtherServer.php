<?php

namespace App\Actions;

use App\DataTransferObject\CallLogDto;
use App\Imports\UserImport;
use App\Models\CallLog;
use App\Models\User;
use App\Service\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\YourModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SyncDataFromOtherServer {

    public ApiService $apiService;
    public function __construct(

    )
    {
        $this->apiService  = new ApiService();
    }

    public function createUserFromImport(Request $request) : mixed
    {$request->validate([
        'file' => 'required|mimes:csv,txt,xlsx',
    ]);

    Excel::import(new UserImport, $request->file('file'));

    return redirect()->back()->with('success', 'Data imported successfully');



    }

    public function fetchUserEncryptionCode(User $user) : mixed
    {
        return  $this->apiService->fetchEncrytedUserCode($user->registered_number);
    }

    public function fetchUserRecords(string $cust_id) : mixed
    {

        return  $this->apiService->fetchUserCallLogs($cust_id);
    }

    public function addToDataBase(array $data) : void
    {
        Arr::map($data, function($item){

            $user = User::where('registered_number', $item['User'])->first();
            If(!CallLog::where('date', $item['Date'])->where('user_id', $user->id)->first()){
                
                CallLog::create(CallLogDto::create($item)->toArray());
            }


        });
    }
}
