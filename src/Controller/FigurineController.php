<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Figurine;
use App\Form\CommentType;
use App\Form\FigurineType;
use Doctrine\ORM\Mapping\Id;
use App\Repository\PictureRepository;
use App\Repository\FigurineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('app/figurine')]
class FigurineController extends AbstractController
{
    #[Route('/', name: 'figurine_index', methods: ['GET'])]
    public function index(FigurineRepository $figurineRepository): Response
    {
        return $this->render('figurine/index.html.twig', [
            'figurines' => $figurineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'figurine_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $figurine = new Figurine();
        $form = $this->createForm(FigurineType::class, $figurine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $picture) {
                $pictureInRepo = md5(uniqid()) . '.' . $picture->guessExtension();
                $picture->move(
                    $this->getParameter('images_directory'),
                    $pictureInRepo
                );
                $img = new Picture();
                $img->setCreateAt(new \DateTime());
                $img->setUrl($pictureInRepo);
                $img->setFigurine($figurine);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($img);
            }

            $figurine->setCreateAt(new \DateTime());
            $figurine->setOwner($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figurine);
            $entityManager->flush();

            return $this->redirectToRoute('figurine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('figurine/new.html.twig', [
            'figurine' => $figurine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'figurine_show', methods: ['GET'])]
    public function show(Figurine $figurine): Response
    {
        return $this->render('figurine/show.html.twig', [
            'figurine' => $figurine,
        ]);
    }

    /* TEST DES FONCTIONNALITES UPVOTE ET DOWNVOTE */

    #[Route('/{id}/upvote', name: 'figurine_upvote', methods: ['GET'])]
    public function upvote(Request $request, FigurineRepository $figurineRepository): Response
    {
        $figurineId = $request->attributes->get('id');
        $figurine = $figurineRepository->find($figurineId);
        $upvote = $figurine->getUpvote();
        $upvote++;
        $figurine->setUpvote($upvote);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($figurine);
        $entityManager->flush();

        return $this->render('figurine/index.html.twig', [
            'figurines' => $figurineRepository->findAll(),
        ]);
    }

    #[Route('/{id}/downvote', name: 'figurine_downvote', methods: ['GET'])]
    public function downvote(Request $request, FigurineRepository $figurineRepository): Response
    {
        $figurineId = $request->attributes->get('id');
        $figurine = $figurineRepository->find($figurineId);
        $downvote = $figurine->getDownvote();
        $downvote++;
        $figurine->setDownvote($downvote);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($figurine);
        $entityManager->flush();

        return $this->render('figurine/index.html.twig', [
            'figurines' => $figurineRepository->findAll(),
        ]);
    }


    /* END */


    #[Route('/{id}/comment', name: 'comment_new', methods: ['GET', 'POST'])]
    public function newComment(Request $request, FigurineRepository $figurineRepository): Response
    {
        $comment = new Comment();
        $user = $this->getUser();
        $figurineId = $request->attributes->get('id');
        $figurine = $figurineRepository->find($figurineId);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreateAt(new \DateTime());
            $comment->setAuthor($user);
            $comment->setFigurine($figurine);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('figurine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'figurine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Figurine $figurine): Response
    {
        $form = $this->createForm(FigurineType::class, $figurine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('figurine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('figurine/edit.html.twig', [
            'figurine' => $figurine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'figurine_delete', methods: ['POST'])]
    public function delete(Request $request, Figurine $figurine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $figurine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figurine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('figurine_index', [], Response::HTTP_SEE_OTHER);
    }
}
