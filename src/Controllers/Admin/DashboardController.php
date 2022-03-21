<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class DashboardController extends Controller
{
    use RequiresUser;

    public function dashboard()
    {
        return view('cms::admin.dashboard');
    }
}
