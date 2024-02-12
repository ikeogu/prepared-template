<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel,WithHeadingRow
{
    /**
    * @param Model $model
    */

    public function model(array $row)
    {
    
        return  User::updateOrCreate(
            [ "registered_number" => $row['registered_numbers']],
            [

            "password" => $row['password'],
            "caller_id" => $row['caller_id'],

        ]);
    }
}
