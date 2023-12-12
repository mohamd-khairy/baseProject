<?php

namespace App\Http\Controllers\API\Global;

use App\Filters\SortFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataEntry\PageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function index(PageRequest $request): JsonResponse
    {
        $query = Audit::with('auditable');

        $data = app(Pipeline::class)->send($query)->through([
            SortFilters::class
        ])->thenReturn();

        $data = request('pageSize') == -1
            ? $data->get()
            : $data->paginate(request('pageSize', 15));

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
     * @param int $id
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
