<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\Post;
use App\Models\Site;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\CreatePostRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(
            resource: Post::query()->latest()->get()
        );
    }

    public function store(CreatePostRequest $request): PostResource
    {
        $site = Site::query()->find($request->integer('site_id'));

        return PostResource::make($site->posts()->create($request->only('title', 'body')));
    }

    public function show(Post $post)
    {
        $post->loadMissing('site');

        return PostResource::make($post);
    }

    /**
     * @throws Throwable
     */
    public function update(EditPostRequest $request, Post $post): JsonResponse
    {
        $post->updateOrFail($request->validated());

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws Throwable
     */
    public function destroy(Post $post)
    {
        $post->deleteOrFail();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
