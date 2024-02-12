<?php

namespace App\Http\Controllers;

use App\Actions\SyncDataFromOtherServer as ActionsSyncDataFromOtherServer;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use SyncDataFromOtherServer;

class ActionController extends Controller
{
    //
    public ActionsSyncDataFromOtherServer $action;

    public function __construct()
    {
        $this->action = new ActionsSyncDataFromOtherServer();
    }


    public function populateUser(Request $request) : JsonResponse
    {
        $this->action->createUserFromImport($request);

        $users = User::latest()->get();

        return $this->success(
            message:"User table Populated",
            data: UserResource::collection($users),
            status:201
        );

    }

    public function populateDataBase() : JsonResponse
    {
        /** @var User $user */
        $users = User::get();

        $users->each(function($item){
            $code = $this->action->fetchUserEncryptionCode($item);
            $user_records = $this->action->fetchUserRecords($code);
            $this->action->addToDataBase($user_records);
        });

        return $this->success(
            message:"Call Log table Populated",
            status:201
        );
    }
}
