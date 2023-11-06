<?php
namespace App\Services;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function getAllPosts()
    {
        return Post::with('user')->orderBy('id','DESC')->paginate(4);
    }

    public function getPostById($postId)
    {
        return Post::with(['comments.user','user'])->withTrashed()->findOrFail($postId);
    }

    public function getOwnPosts()
    {
        return Post::with('user')
            ->withTrashed()
            ->where('created_by',Auth::id())
            ->orderBy('id','DESC')
            ->paginate(4);
    }

    public function getFilterPostsByAuthorId($authorId)
    {
        return Post::with('user')->whereHas('user',fn($q)=>$q->where('id',$authorId))->paginate(4);
    }

    public function createPost(array $postDetails)
    {
        $postDetails['image']=isset($postDetails['image']) ? $this->postImageUpload($postDetails['image']) ?? null : null;
        $postDetails['created_by'] = Auth::id();
        return Post::create($postDetails);
    }

    public function updatePost(array $postDetails)
    {
        $post = $this->getPostById($postDetails['id']);

        if(isset($postDetails['image'])){
            $postDetails['image']=$this->postImageUpload($postDetails['image']);
        }else{
            unset($postDetails['image']);
        }

        return Post::where('id',$postDetails['id'])->update($postDetails);
    }

    protected function postImageUpload($postImg)
    {
        return $postImg->store('post_images', 'public');
    }

    protected function postImageUnlink($postImg)
    {
        if (Storage::disk('public')->exists($postImg)){
            Storage::disk('public')->delete($postImg);
        }
    }

    public function deletePost($id)
    {
        $post = $this->getPostById($id);
        if($post->id){
            return Post::where('id',$id)->delete();
        }
        return false;
    }

    public function restorePost($id)
    {
        return Post::withTrashed()
        ->where('id', $id)
        ->restore();
    }
}