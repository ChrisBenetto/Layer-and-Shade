<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('blog/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
