<?php

namespace App\Http\Controllers\API\Global;

use App\Filters\SearchFilters;
use App\Filters\SortFilters;
use App\Http\Controllers\Controller;
use App\Http\Resources\Global\PageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-log', ['only' => ['index', 'show']]);
        $this->middleware('permission:delete-log', ['only' => ['destroy']]);
    }

    /**
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function index(PageRequest $request): JsonResponse
    {
        $query = app(Pipeline::class)->send(Audit::with('auditable'))->through([
            SearchFilters::class,
            SortFilters::class
        ])->thenReturn();

        $data = request('pageSize') == -1
            ? getData(query: $query, method: 'get')
            : getData(query: $query, method: 'paginate');

        return successResponse(['activity' => $data]);
    }

    /**
     * @param Audit $audit
     * @return JsonResponse
     */
    public function show(Audit $audit): JsonResponse
    {
        $audit->load('auditable');

        return successResponse($audit);
    }

    /**
     * @param int|null $id
     * @return JsonResponse
     */
    public function destroy(int $id = null): JsonResponse
    {
        $ids = empty(request('ids')) ? [$id] : explode(',', request('ids'));

        return DB::transaction(function () use ($ids) {

            Audit::whereIn('id', $ids)->delete();

            return successResponse(message: 'Activity(s) have been successfully deleted');
        });
    }
}
