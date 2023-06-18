<?php

namespace App\Controller\Service;

use App\Entity\Comment;
use App\Repository\CommentRepository;

class CommentService
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
    ) {}

    private function isCommentSafe(Comment $comment): bool
    {
        sleep(5);
        return $comment->getContent() !== null;
    }

    public function saveComment(Comment $comment): void
    {
        if ($this->isCommentSafe($comment)) {
            $this->commentRepository->save($comment, true);
        }
    }
}
