<?php

namespace Codictive\Cms\Controllers\App;

use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class AppController extends Controller
{
    use RequiresUser;

    public function index()
    {
        return view('cms::app.index');
    }
}
