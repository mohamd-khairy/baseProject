<?php

namespace App\Services\Report;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeReportService implements IReport
{
    public array $types;
    public string $table = 'form_requests';
    public array $filter;

    /**
     * @param array $filter
     */
    public function __construct(array $filter)
    {
        DB::statement('SET sql_mode = " "');

        $this->filter = $filter;
        $this->types = [
            "HomeCards", 'CaseCards'
        ];
    }

    /**
     * @return array
     */
    final public function report(): array
    {
        $types = $this->types;
        if (isset($this->filter['type']) && $this->filter['type'] !== 'all') {
            $types = explode(',', $this->filter['type']);
        }
        foreach ($types as $type) {

            $camelKey = ucfirst(Str::camel($type));
            $func_name = "get{$camelKey}"; //prepare name of report function

            try {
                $data[$type] = $this->$func_name(); //get report data and push it in array
            } catch (\Error $e) {
                //continue
            }
        }

        return $data ?? [];
    }

    /**
     * @return array
     */
    final public function getHomeCards(): array
    {
        return [
            "case_count" => DB::table('causes')->whereNull('deleted_at')->count(),
            "advise_count" => DB::table('advises')->whereNull('deleted_at')->count(),
            // "treatment_count" => DB::table('treatments')->count(),
            "tasks_count" => DB::table('tasks')->count(),
            "file_count" => DB::table('contracts')->count(),
            // "review_count" => DB::table('reviews')->count(),
            // "project_count" => DB::table('projects')->count(),
            "users_count" => DB::table('users')->whereNull('deleted_at')->where('type','user')->count()
        ];
    }

    /**
     * @return array
     */
    final public function getCaseCards(): array
    {
        return [
            "case_count" => DB::table('causes')->whereNull('deleted_at')->count(),
            "sessions_count" => DB::table('cause_sessions')->count(),
            "amountCount" => DB::table('cause_compensations')->count(),
            "courtsCount" => DB::table('cause_judgments')->count()
        ];
    }
}
