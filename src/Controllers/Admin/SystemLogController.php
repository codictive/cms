<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\SystemLog;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Controllers\Controller;

class SystemLogController extends Controller
{
    use RequiresUser;

    /**
     * Displays system logs.
     *
     * @return view
     */
    public function index(Request $request)
    {
        $logs = SystemLog::orderBy('id', 'DESC');
        if ($request->input('level')) {
            $logs = $logs->where('level', $request->input('level'));
        }
        if ($request->input('query')) {
            $logs = $logs->where('message', 'LIKE', '%' . $request->input('query') . '%');
        }
        $logs = $logs->paginate(100);

        return view('admin.system_logs', ['logs' => $logs]);
    }

    /**
     * Deletes system logs from the database.
     *
     * @return redirect
     */
    public function truncate()
    {
        SystemLog::truncate();

        return redirect()->route('admin.system_logs.index');
    }
}
