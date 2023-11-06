<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    protected $postService;
    protected $userService;

    public function __construct(PostService $postService, UserService $userService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
    }

    public function list(Request $request): Response
    {
        $posts = $request->author_id ? $this->postService->getFilterPostsByAuthorId($request->author_id) : $this->postService->getAllPosts();
        return Inertia::render('Post/List',[
            'posts'=> $posts,
            'users'=> $this->userService->getAllUser(),
            'author_name'=> $request->author_id ?? 'All'
        ]);
    }

    public function own()
    {
        return Inertia::render('Post/Own',[
            'posts'=> $this->postService->getOwnPosts()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    public function show($id): Response
    {
        return Inertia::render('Post/Show',[
            'post'=>$this->postService->getPostById($id),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'text' => ['required'],
            'image' => ['required'],
        ]);

        $this->postService->createPost($request->all());

        return redirect('/post');
    }

    public function edit($id)
    {
        return Inertia::render('Post/Edit',[
            'post'=>$this->postService->getPostById($id)
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => ['required'],
            'title' => ['required'],
            'text' => ['required']
        ]);

        $this->postService->updatePost($request->all());
        return redirect('/post');
    }

    public function delete($id): RedirectResponse
    {
        $this->postService->deletePost($id);
        return redirect('/post');
    }

    public function restore($id): RedirectResponse
    {
        $this->postService->restorePost($id);
        return redirect('/post');
    }
}
