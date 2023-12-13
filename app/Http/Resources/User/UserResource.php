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
            "id" => $this->id ??  null,
            "name" =>  $this->name ?? null,
            "avatar" => $this->avatar ?? null,
            "phone" => $this->phone ?? null,
            "email" => $this->email ?? null,
            "department_id" => $this->department_id ?? null,
            "email_verified_at" => $this->email_verified_at ?? null,
            "status" => $this->status ?? null,
            "roles" => BasicResource::collection($this->roles),
            'permissions' => $permissions ?? null,
        ];
    }
}
