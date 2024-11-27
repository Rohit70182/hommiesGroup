<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Comment\Entities\Comment;

class CommentComposer
{
    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $comments = Comment::where('model_type', Request()->path())->get();
        $view->with(compact('comments'));
    }
}
