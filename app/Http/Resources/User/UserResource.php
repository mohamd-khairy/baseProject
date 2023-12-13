<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Global\BasicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $permissions = DB::table('role_has_permissions')
            ->select('permissions.id', 'permissions.name')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->whereIn('role_id', $this->roles->pluck('id'))
            ->distinct()
            ->pluck('name');

        return [
            "id" => $this->id,
            "name" =>  $this->name ,
            "avatar" => $this->avatar ,
            "phone" => $this->phone ,
            "email" => $this->email ,
            "department_id" => $this->department_id ,
            "email_verified_at" => $this->email_verified_at ,
            "status" => $this->status ,
            "roles" => BasicResource::collection($this->roles),
            'permissions' => $permissions ,
        ];
    }
}
