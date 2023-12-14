<?php

namespace App\Http\Controllers\API\Global;

use App\Filters\SearchFilters;
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

        $query = app(Pipeline::class)->send($model->onlyTrashed())->through([
            SearchFilters::class,
            SortFilters::class
        ])->thenReturn();

        $data = request('pageSize') == -1
            ? getData(query: $query, method: 'get')
            : getData(query: $query, method: 'paginate');

        return successResponse(['trashed' => $data]);
    }

    /**
     * @param int $id
     * @param string $type
     * @return JsonResponse
     */
    public function show(int $id, string $type): JsonResponse
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
    public function restore(int $id, string $type): JsonResponse
    {
        $model = app(detectModelPath($type));

        $data = $model->onlyTrashed()->findOrFail($id);

        $data->restore();

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

        $data->forceDelete();

        return successResponse($data);
    }
}
