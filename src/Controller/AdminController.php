<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    /* GESTION DES COMMENTAIRES */
    #[Route('/comments', name: 'showComments', methods: ['GET'])]
    public function showComments(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }
    #[Route('/comments/{id}', name: 'comment_delete', methods: ['GET', 'DELETE', 'POST'])]
    public function deleteComment($id, EntityManagerInterface $manager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Comment::class);
        $commentById = $repo->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($commentById);
        $manager->flush();
        return $this->redirectToRoute('showComments', [], Response::HTTP_SEE_OTHER);
    }

    /* GESTION DES IMAGES */
    #[Route('/pictures', name: 'showPictures', methods: ['GET'])]
    public function showPicture(PictureRepository $pictureRepository): Response
    {
        return $this->render('picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }

    #[Route('/pictures/{id}', name: 'picture_delete', methods: ['GET', 'DELETE', 'POST'])]
    public function deletePicture($id, EntityManagerInterface $manager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Picture::class);
        $pictureById = $repo->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($pictureById);
        $manager->flush();
        return $this->redirectToRoute('showPictures', [], Response::HTTP_SEE_OTHER);
    }
    /* GESTION DES UTILISATEURS */
    #[Route('/users', name: 'showUsers', methods: ['GET'])]
    public function showUsers(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/users/{id}', name: 'user_delete', methods: ['GET', 'DELETE', 'POST'])]
    public function deleteUser($id, EntityManagerInterface $manager): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $userById = $repo->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($userById);
        $manager->flush();
        return $this->redirectToRoute('showUsers', [], Response::HTTP_SEE_OTHER);
    }
    /* GESTION DES CATEGORIES */
}
