<?php

namespace App\Http\Controllers;

use App\Http\Resources\CallLogResource;
use App\Models\CallLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CallLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $response = QueryBuilder::for(CallLog::class)
             ->allowedFilters(['called_user','country_network',
             'caller_id','duration','date', 'status','' ])
            ->get();

        return $this->success(
            message:"Call Logs",
            data:CallLogResource::collection($response),
            status: 200
        );
    }



}
