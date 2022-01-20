<?php

namespace App\Controller\Admin;

use App\Entity\Jeu;
use App\Form\JeuType;
use App\Repository\JeuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/jeu')]
class JeuController extends AbstractController
{
    #[Route('/', name: 'admin_jeu_index', methods: ['GET'])]
    public function index(JeuRepository $jeuRepository): Response
    {
        return $this->render('admin/jeu/index.html.twig', [
            'jeus' => $jeuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_jeu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jeu = new Jeu();
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jeu);
            $entityManager->flush();

            return $this->redirectToRoute('admin_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/jeu/new.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_jeu_show', methods: ['GET'])]
    public function show(Jeu $jeu): Response
    {
        return $this->render('admin/jeu/show.html.twig', [
            'jeu' => $jeu,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_jeu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/jeu/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_jeu_delete', methods: ['POST'])]
    public function delete(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jeu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_jeu_index', [], Response::HTTP_SEE_OTHER);
    }
}
