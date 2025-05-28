<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Services\Post\PostService;
use App\Models\Post;

class PostController extends Controller
{

    public function __construct(protected PostService $service)
    {}

    public function index(Request $request)
    {
        $posts = $this->service->getAll($request->only('status'));

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.form', [ 'post' => new Post() ]);
    }

    public function store(CreatePostRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('posts.index')->with('message', 'Post creado exitosamente!');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(int $id)
    {
        $post = $this->service->find($id);

        return view('posts.form', compact('post'));
    }

    public function update(UpdatePostRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('posts.index')->with('message', 'Post Actualizado exitosamente!');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->route('posts.index')->with('message', 'Post Eliminado exitosamente!');
    }
}
