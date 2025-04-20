<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Models\Comment;
use App\Models\Podcast;
use App\Services\Comment\CommentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    use ResponseTrait;

    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function addComment(CommentRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;

        $data = $this->commentService->addComment($request->validated(),$userId);

        return self::success($data['data'],$data['message']);
    }

    public function getComments(Podcast $podcast): JsonResponse
    {
        $data = $this->commentService->getPodcastComment($podcast);

        return self::success($data['data'],$data['message']);
    }

    public function deleteComment(Comment $comment): JsonResponse
    {
        Gate::authorize('delete', $comment);

        $data = $this->commentService->deleteComment($comment);

        return self::success($data['data'],$data['message']);
    }
}
