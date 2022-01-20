<?php

namespace App\Controller\Admin;

use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as Hasher;

#[Route('/admin/joueur')]
class JoueurController extends AbstractController
{
    #[Route('/', name: 'admin_joueur_index', methods: ['GET'])]
    public function index(JoueurRepository $joueurRepository): Response
    {
        return $this->render('admin/joueur/index.html.twig', [
            'joueurs' => $joueurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_joueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Hasher $hasher): Response
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Hash password
            $mdp = $form->get("password")->getData();
            $nouveauMdp = $hasher->hashPassword($joueur, $mdp);
            $joueur->setPassword($nouveauMdp);
            //------------------------------

            $entityManager->persist($joueur);
            $entityManager->flush();

            return $this->redirectToRoute('admin_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/joueur/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_joueur_show', methods: ['GET'])]
    public function show(Joueur $joueur): Response
    {
        return $this->render('admin/joueur/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_joueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joueur $joueur, EntityManagerInterface $entityManager, Hasher $hasher): Response
    {
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($mdp = $form->get("password")->getData()) {
                $nouveauMdp = $hasher->hashPassword($joueur, $mdp);
                $joueur->setPassword($nouveauMdp);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/joueur/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_joueur_delete', methods: ['POST'])]
    public function delete(Request $request, Joueur $joueur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joueur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($joueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_joueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
