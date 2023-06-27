<?php

namespace App\Controller;

use App\Controller\Service\CommentService;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Message\CommentMessage;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/{post}', name: 'app_post_show')]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $this->createForm(CommentType::class, null, [
                'action' => $this->generateUrl('app_post_comment', ['post' => $post->getId()]),
                'method' => 'POST',
            ])
        ]);
    }

    #[Route('/{post}/comment/bad', name: 'app_post_comment_bad', methods: ['POST'], priority: 5)]
    public function addPostBad(Post $post, Request $request, CommentService $commentService): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setPost($post)
                ->setCreatedAt(new \DateTimeImmutable())
            ;
            $commentService->saveComment($comment);
        }
        return $this->redirectToRoute('app_post_show', ['post' => $post->getId()]);
    }

    #[Route('/{post}/comment', name: 'app_post_comment', methods: ['POST'])]
    public function addPost(Post $post, Request $request, MessageBusInterface $bus): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch(new CommentMessage($form->getData()["content"], $post->getId()));
        }
        return $this->redirectToRoute('app_post_show', ['post' => $post->getId()]);
    }
}
