<?php

namespace App\Controller;

use App\Entity\Figurine;
use App\Form\Figurine1Type;
use App\Repository\FigurineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/figurine')]
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
        $figurine = new Figurine();
        $form = $this->createForm(Figurine1Type::class, $figurine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    #[Route('/{id}/edit', name: 'figurine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Figurine $figurine): Response
    {
        $form = $this->createForm(Figurine1Type::class, $figurine);
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
        if ($this->isCsrfTokenValid('delete'.$figurine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figurine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('figurine_index', [], Response::HTTP_SEE_OTHER);
    }
}
