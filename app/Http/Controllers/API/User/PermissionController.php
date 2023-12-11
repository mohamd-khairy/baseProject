<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:read-permission', ['only' => ['index', 'permissions']]);
        $this->middleware('permission:create-permission', ['only' => ['store']]);
        $this->middleware('permission:update-permission', ['only' => ['update']]);
        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $permissions = Permission::with('roles')->latest()->get();

        return successResponse($permissions);
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(Permission $permission): JsonResponse
    {
        return successResponse($permission);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $permission = Permission::create($request->except('_token'));

        return successResponse($permission, 'permission has been created successfully');
    }

    /**
     * @param Permission $permission
     * @param PermissionRequest $request
     * @return JsonResponse
     */
    public function update(Permission $permission, PermissionRequest $request): JsonResponse
    {
        $permission->update($request->except('_token', '_method'));

        return successResponse($permission, 'permission has been updated successfully');
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();

        return successResponse(message: 'permission has been deleted successfully');
    }

    /**
     * @return JsonResponse
     */
    public function permissions(): JsonResponse
    {
        $permissions = Permission::get()->groupBy('group');

        return successResponse($permissions);
    }
}
