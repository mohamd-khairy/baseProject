<?php

namespace App\Http\Controllers\API\User;

use App\Filters\SearchFilters;
use App\Filters\SortFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataEntry\PageRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:read-user|read-beneficiary', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user|create-beneficiary', ['only' => ['store']]);
        $this->middleware('permission:update-user|update-beneficiary', ['only' => ['update']]);
        $this->middleware('permission:delete-user|delete-beneficiary', ['only' => ['destroy']]);
    }

    /**
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function index(PageRequest $request): JsonResponse
    {
        $query = User::with(['roles', 'permissions', 'department'])
            ->ignoreType('user')
            ->excludeAdmins()
            ->excludeLoggedInUser();

        $data = app(Pipeline::class)->send($query)->through([
            SearchFilters::class, SortFilters::class
        ])->thenReturn();

        $data = request('pageSize') == -1
            ? $data->get()
            : $data->paginate(request('pageSize', 15));

        return successResponse(['users' => $data]);
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {

            $user = User::create($request->validated());

            $user->assignRole($request->roles ? resolveArray($request->roles) : ['employee']);

            return successResponse($user, 'User has been successfully created');
        });
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        $user->load('roles');

        return successResponse($user);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        return DB::transaction(function () use ($user, $request) {
            $user->fill($request->validated())->save();

            if ($request->has('roles')) {
                $user->roles()->sync(resolveArray($request->roles));
            }

            return successResponse($user, 'User has been successfully updated');
        });
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $ids = empty(request('ids')) ? [$id] : explode(',', request('ids'));

        return DB::transaction(function () use ($ids) {
            User::whereIn('id', $ids)->each(function ($user) {
                UploadService::delete($user->avatar);
                $user->delete();
            });

            return successResponse('User(s) have been successfully deleted');
        });
    }
}