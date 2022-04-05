<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Feedback;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class FeedbackController extends Controller
{
    use RequiresUser;

    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(30);

        return view('cms::admin.feedback.index', ['feedbacks' => $feedbacks]);
    }

    public function show(Feedback $feedback)
    {
        $feedback->seen = true;
        $feedback->save();

        return view('cms::admin.feedback.show', ['feedback' => $feedback]);
    }
}
