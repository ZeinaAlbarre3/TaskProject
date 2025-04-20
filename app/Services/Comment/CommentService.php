<?php

namespace App\Services\Comment;

use App\Exceptions\Types\CustomException;
use App\Models\Comment;
use App\Models\Podcast;
use Illuminate\Support\Facades\Gate;

class CommentService
{
    public function addComment($request,$userId): array
    {
        $comment = Comment::query()->create([
            'user_id' => $userId,
            'podcast_id' => $request['podcast_id'],
            'body' => $request['body'],
            'parent_id' => $request['parent_id'] ?? null,
        ]);

        return ['data' => $comment,'message' => 'Comment successfully.','code' => 200];
    }
    public function getPodcastComment(Podcast $podcast): array
    {
        $comments = Comment::with(['replies', 'user'])
            ->where('podcast_id', $podcast['id'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return ['data' => $comments,'message' => 'Comments have been shown successfully.','code' => 200];
    }
    public function deleteComment(Comment $comment): array
    {
        $comment->delete();

        return ['data' => [],'message' => 'Comment successfully deleted.','code' => 200];
    }
}
