<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RoleRequest;
use App\Http\Resources\User\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:read-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['store']]);
        $this->middleware('permission:update-role', ['only' => ['update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $query = Role::with('permissions')
            ->whereNotIn('id', auth()->user()->roles->pluck('id')->toArray())
            ->latest();

        $data = request('pageSize') == -1
            ? getData(query: $query, method: 'get', resource: RoleResource::class)
            : getData(query: $query, method: 'paginate', resource: RoleResource::class);

        return successResponse($data);
    }

    /**
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $data = $request->only(['name', 'display_name']) + ['guard_name' => 'web'];

            $role = Role::create($data);

            $role->syncPermissions($request->permissions);

            return successResponse($role, 'Role has been created successfully');
        });
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        $role['permissions'] = $role->permissions()->get()->pluck('name');

        return successResponse([
            'role' => $role,
            'permissions' => Permission::get()->groupBy('group'),
        ]);
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        return DB::transaction(function () use ($request, $role) {

            $data = $request->only(['name', 'display_name']) + ['guard_name' => 'web'];

            $role->update($data);

            $role->syncPermissions($request->permissions);

            return successResponse($role, 'Role has been updated successfully');
        });
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        return DB::transaction(function () use ($role) {

            $role->delete();
            $role->syncPermissions([]);

            return successResponse(message: 'Role has been deleted successfully');
        });
    }
}
