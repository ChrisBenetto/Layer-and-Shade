<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    #[Route('/app', name: 'index')]
    public function index(): Response
    {
        return $this->render('figurine/index.html.twig', [
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
