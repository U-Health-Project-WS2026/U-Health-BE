<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id"=>$this->user_id,
            "username"=>$this->username,
            "email"=>$this->email,
            "email_verfied_at"=>$this->email_verified_at
        ];
    }
}
