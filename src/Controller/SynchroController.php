<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\Synchro;
use App\Repository\CategorieRepository;
use App\Repository\JeuRepository;
use App\Repository\JoueurRepository;
use App\Repository\SynchroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SynchroController extends AbstractController
{
    #[Route('/matching', name: 'matching', methods: ['POST', 'GET'])]
    public function matching(JoueurRepository $jr, JeuRepository $jeuRepository, Request $rq, CategorieRepository $cr): Response
    {
        if($rq->request->get("jeu")) {
            $joueurtrie = $jeuRepository->find($rq->request->get("jeu"))->getJoueurs();
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        } elseif($rq->request->get("categorie")){
            $joueurtrie = $cr->find($rq->request->get("categorie"))->getJoueurs();
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        } else {
            $joueurtrie = $jr->findByTryhardMeterSame($this->getUser()->getTryhardMeter(), $this->getUser()->getId());
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        }
    }

    #[Route('/matching/{id}', name: 'matchingFilter', methods: ['GET'])]
    public function matchingFiltre($id, JoueurRepository $jr, JeuRepository $jeuRepository, CategorieRepository $cr): Response
    {
        if($id === "weakTryhard"){
            $joueurtrie = $jr->findByTryhardMeter0_2($this->getUser()->getId());
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        }
        if($id === "littleWeakTryhard"){
            $joueurtrie = $jr->findByTryhardMeter2_4($this->getUser()->getId());
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        }
        if($id === "mediumTryhard"){
            $joueurtrie = $jr->findByTryhardMeter4_6($this->getUser()->getId());
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        }
        if($id === "littleStrongTryhard"){
            $joueurtrie = $jr->findByTryhardMeter6_8($this->getUser()->getId());
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        }
        if($id === "strongTryhard"){
            $joueurtrie = $jr->findByTryhardMeter8_10($this->getUser()->getId());
            return $this->render('synchro/matching.html.twig', [
                'joueurs' => $joueurtrie,
                'jeux' => $jeuRepository->findAll(),
                'categories' => $cr->findAll(),
            ]);
        } 
    }

    #[Route('/matching_detail/{id}', name: 'matchingDetail', methods: ['GET'])]
    public function matchingShow($id, SynchroRepository $sr, JoueurRepository $jr): Response
    {
        $joueur = $jr->find($id);

        if($joueur){
            $allMatchWithCurrentUserAndThisId = $sr->findMatchByCurrentUser($this->getUser()->getId(), $id);
            $countOfMatch = count($allMatchWithCurrentUserAndThisId);

            $allMatchWithThisIdAndCurrentUser = $sr->findMatchByOtherUser($this->getUser()->getId(), $id);
            $countOfMatch2 = count($allMatchWithThisIdAndCurrentUser);

            return $this->render('synchro/matchingDetail.html.twig', [
                'joueur' => $joueur,
                'countOfMatchFromUser' => $countOfMatch,
                'countOfMatchFromOtherUser' => $countOfMatch2,
            ]);
        }
        return $this->redirectToRoute('matching');
    }

    #[Route('/matching_detail/{id}/supr', name: 'matchingDetailSupr', methods: ['POST'])]
    public function suprMach($id, SynchroRepository $sr, JoueurRepository $jr, EntityManagerInterface $ei): Response
    {
        $joueur = $jr->find($id);

        if($joueur){
            $allMatchWithCurrentUserAndThisId = $sr->findMatchByCurrentUser($this->getUser()->getId(), $id);
            if (count($allMatchWithCurrentUserAndThisId) == 1){
                $ei->remove($allMatchWithCurrentUserAndThisId[0]); // $allMatchWithCurrentUserAndThisId est un tableau avec 1 seul objet donc on peut donner l'objet avec l'index 0
                $ei->flush();
            }
        }

        return $this->redirectToRoute('match', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/matching_detail/{id}/supr2', name: 'matchingDetailSupr2', methods: ['POST'])]
    public function suprMach2($id, SynchroRepository $sr, JoueurRepository $jr, EntityManagerInterface $ei): Response
    {
        $joueur = $jr->find($id);

        if($joueur){
            $allMatchWithThisIdAndCurrentUser = $sr->findMatchByOtherUser($this->getUser()->getId(), $id);
            if (count($allMatchWithThisIdAndCurrentUser) == 1){
                $ei->remove($allMatchWithThisIdAndCurrentUser[0]); // $allMatchWithCurrentUserAndThisId est un tableau avec 1 seul objet donc on peut donner l'objet avec l'index 0
                $ei->flush();
            }
        }

        return $this->redirectToRoute('your_match', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/match/{id?}', name: 'match', methods: ['GET'])]
    public function match($id, JoueurRepository $jr, SynchroRepository $sr, EntityManagerInterface $entityManager): Response
    {
        if(!empty($id)){
            $match = new Synchro();
            $match->setJoueur1($this->getUser());
            $match->setJoueur2($jr->find($id));

            $entityManager->persist($match);
            $entityManager->flush();

            return $this->redirectToRoute('match', [], Response::HTTP_SEE_OTHER);
        }

        $allJoueurMatched = $this->getUser()->getSynchros();

        return $this->render('synchro/match.html.twig', [
            'matchs' => $allJoueurMatched,
        ]); 
    }

    #[Route('/havebeenmatched', name: 'your_match')]
    public function haveBeenMatched(SynchroRepository $sr, Request $rq): Response
    {
        $allJoueurMatched2 = $this->getUser()->getSynchros2();

        return $this->render('synchro/haveBeenMatched.html.twig', [
            'matchs' => $allJoueurMatched2,
        ]);
    }
}
