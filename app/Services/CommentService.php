<?php
namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentService
{
    public function createComment(array $commentDetail)
    {
        $commentDetail['user_id'] = Auth::id();
        return Comment::create($commentDetail);
    }

    public function updateComment(array $commentDetail)
    {
        return Comment::where('id',$commentDetail['id'])->update($commentDetail);
    }
}