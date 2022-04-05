<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Codictive\Cms\Models\ActivityLog;
use Codictive\Cms\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogController extends Controller
{
    /**
     * Displays system logs.
     *
     * @return view
     */
    public function index(Request $request)
    {
        $logs = ActivityLog::with(['user'])->latest();
        if ($request->query('user_id')) {
            $logs = $logs->where('user_id', $request->query('user_id'));
        }
        if ($request->query('action')) {
            $logs = $logs->where('action', $request->query('action'));
        }
        if ($request->query('related_type')) {
            $logs = $logs->where('related_type', "App\\Models\\{$request->query('related_type')}");
        }
        if ($request->query('related_id')) {
            $logs = $logs->where('related_id', $request->query('related_id'));
        }
        if ($request->query('query')) {
            $logs = $logs->where(function (Builder $query) use ($request) {
                return $query->where('data', 'LIKE', "%{$request->query('query')}%")
                    ->orWhere('note', 'LIKE', "%{$request->query('query')}%");
            });
        }

        $logs    = $logs->paginate(100);
        $actions = [
            ActivityLog::ACTION_LOGIN,
            ActivityLog::ACTION_LOGOUT,
            ActivityLog::ACTION_REGISTER,
        ];

        return view('cms::admin.activity_logs.index', ['logs' => $logs, 'actions' => $actions]);
    }

    public function show(ActivityLog $log)
    {
        return view('cms::admin.activity_logs.show', ['log' => $log]);
    }
}
