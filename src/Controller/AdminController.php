<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin', methods: ['GET'])]
    public function admin(): Response
    {
        return $this->render('blog/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/comments', name: 'showComments', methods: ['GET'])]
    public function showComments(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }
    #[Route('/pictures', name: 'showPictures', methods: ['GET'])]
    public function showPicture(PictureRepository $pictureRepository): Response
    {
        return $this->render('picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }
    #[Route('/users', name: 'showUsers', methods: ['GET'])]
    public function showUsers(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
