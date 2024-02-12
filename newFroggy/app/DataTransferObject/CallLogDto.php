<?php


namespace App\DataTransferObject;

use App\Models\User;
use Spatie\LaravelData\Data;

class CallLogDto extends Data
{


    public function __construct(
        public string $date,
        public string $user,
        public string $called_user,
        public string $caller_id,
        public string $country_network,
        public string $status,
        public string $duration,
        public string $cost_euro,
        public int $user_id

    )
    {

    }

    public static function create(array $data) : self
    {
        $user = User::where('registered_number', $data['User'])->first();


        return CallLogDto::from([
            'date' => $data['Date'],
            'user' => $data['User'],
            'called_user' => $data['Called_user'],
            'caller_id' => $data['Caller_ID'],
            'status' => $data['Status'],
            'duration' => $data['Duration'],
            'cost_euro' => $data['Cost_Euro'],
            'country_network' => $data['Country_Network'],
            'user_id' => $user->id

        ]);
    }

}
