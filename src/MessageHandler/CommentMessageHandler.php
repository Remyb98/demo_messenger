<?php

namespace App\MessageHandler;

use App\Controller\Service\CommentService;
use App\Entity\Comment;
use App\Message\CommentMessage;
use App\Repository\PostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CommentMessageHandler
{
    public function __construct(
        private CommentService $commentService,
        private PostRepository $postRepository,
    )
    {}

    public function __invoke(CommentMessage $message)
    {
        $comment = new Comment();
        $comment
            ->setContent($message->getContent())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setPost($this->postRepository->find($message->getPostId()))
        ;
        $this->commentService->saveComment($comment);
    }
}
