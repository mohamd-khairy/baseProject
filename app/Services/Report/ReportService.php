<?php


namespace App\Services\Report;

use Illuminate\Support\Facades\DB;
use RuntimeException;

class ReportService
{
    public array $types;
    public string $table = 'form_requests';
    public array $filter;

    public function __construct(array $filter)
    {
        DB::statement('SET sql_mode = " "');

        $this->filter = $filter;
        $this->types = [];
    }

    public static function handle($filter): array
    {
        try {
            if (!$reportObject = self::enableReport($filter)) {
                return [];
            }

            return $reportObject->report();

        } catch (\Error $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public static function enableReport($filter): mixed
    {
        $className = ucfirst($filter['page'] ?? 'home') . 'ReportService';

        $path = "\App\Services\Report\\" . $className;

        try {
            return new $path($filter);

        } catch (\Error $e) {
            return false;
        }
    }
}
