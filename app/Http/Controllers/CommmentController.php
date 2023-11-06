<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;

class CommmentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => ['required'],
            'comment' => ['required'],
        ]);

        $this->commentService->createComment($request->all());
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'post_id' => ['required'],
            'comment' => ['required'],
        ]);

        $this->commentService->updateComment($request->all());
    }
}
