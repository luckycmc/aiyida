<?php

namespace App\Http\Controllers;

use App\Exports\QueryResultExport;
use App\Models\QueryLog;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dev(Request $request)
    {
        $sql = $request->input('sql');
        $export = $request->input('exportFormat') ?? null;

        // 执行sql
        try {
            $result = DB::select($sql);
            // 记录查询日志
            $this->logQuery(auth()->user()->name, $sql, null);
            if (!is_null($export)) {
                if ($export == 'excel') {
                    return $this->exportToExcel($result);
                } else if ($export == 'json') {
                    return response()->json($result);
                }
            } else {
                // 手动创建分页器
                $currentPage = Paginator::resolveCurrentPage();
                $perPage = 10;
                $usersCollection = collect($result);
                $currentPageItems = $usersCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $paginatedUsers = new Paginator($currentPageItems, count($usersCollection), $perPage, array($currentPage));
                return view('list',['users' => $paginatedUsers]);
            }
        } catch (\Exception $e) {
            // 记录查询日志
            $this->logQuery(auth()->user()->name, $sql, $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 记录查询日志的方法
    protected function logQuery($user, $sql, $error)
    {
        $log = new QueryLog();
        $log->user = $user;
        $log->sql = $sql;
        $log->error = $error;
        $log->save();
    }

    // 导出到 Excel 的方法
    protected function exportToExcel($results)
    {
        return Excel::download(new QueryResultExport($results), 'query_results.xlsx');
    }

}
