<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /* TEST ADMIN */
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /* */
    #[Route('/app', name: 'index')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    #[Route('/app/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('blog/profile.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
