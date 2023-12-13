<?php

namespace App\Http\Controllers\API\Global;

use App\Filters\SortFilters;
use App\Http\Controllers\Controller;
use App\Http\Resources\Global\PageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class TrashController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-trash', ['only' => ['index', 'show']]);
        $this->middleware('permission:restore-trash', ['only' => ['restore']]);
        $this->middleware('permission:delete-trash', ['only' => ['destroy']]);
    }

    /**
     * @param PageRequest $request
     * @param string $type
     * @return JsonResponse
     */
    public function index(PageRequest $request, string $type): JsonResponse
    {
        $model = app(detectModelPath($type));

        $query = $model->onlyTrashed();

        $data = app(Pipeline::class)->send($query)->through([
            SortFilters::class
        ])->thenReturn();

        $data = request('page') == -1
            ? $data->get()
            : $data->paginate(request('page', 15));

        return successResponse(['trashed' => $data]);
    }

    /**
     * @param int $id
     * @param string $type
     * @return JsonResponse
     */
    public function restore(int $id, string $type): JsonResponse
    {
        $model = app(detectModelPath($type));

        $data = $model->onlyTrashed()->findOrFail($id);

        return successResponse($data);
    }

    /**
     * @param int $id
     * @param string $type
     * @return JsonResponse
     */
    public function destroy(int $id, string $type): JsonResponse
    {
        $model = app(detectModelPath($type));

        $data = $model->onlyTrashed()->findOrFail($id);

        if ($data)
            $data->forceDelete();

        return successResponse($data);
    }
}
