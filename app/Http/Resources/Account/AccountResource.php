<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'agency' => [
                'number' => $this->agency->number,
                'name' => $this->agency->name,
            ],
            'holder' => [
                'name' => $this->holder->name,
                'email' => $this->holder->email,
            ],
            'status' => $this->status,
        ];
    }
}
