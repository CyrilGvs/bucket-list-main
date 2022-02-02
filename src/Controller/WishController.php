<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Services\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list')]
    public function list(
        WishRepository $wishRepository
    ): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);
        return $this->render('wish/list.html.twig',
            compact("wishes")
        );
    }

    #[Route('/detail/{id}', name: 'wish_detail')]
    public function detail(
        Wish $wish
    ): Response
    {
        return $this->render('wish/detail.html.twig',
            compact("wish")
        );
    }



    #[IsGranted('ROLE_USER')]
    #[Route('/ajoutFormulaire', name: 'wish_ajoutFormulaire')]
    public function ajoutFormulaire(
        Request        $request,
        WishRepository $wishRepository, // Si SELECT
        EntityManagerInterface $entityManager,// Si INSERT,DELETE, UPDATE
        Censurator $cens
    ): Response
    {
        $wish = new Wish(); // Creation d'une nouvelle instance de la class Wish
        $monFormulaire = $this->createForm(WishType::class, $wish); // CRéation d'un nouveau formulaire
        $monFormulaire->handleRequest($request);
        $descriptionPure=$cens->purify($wish->getDescription());
        $authorPure=$cens->purify($wish->getAuthor());
        $wish->setDescription($descriptionPure);
        $wish->setAuthor($authorPure);
        $wish->setIsPublished('true');
        $wish->setDateCreated(new \DateTime());

        if (
            $monFormulaire->isSubmitted()
            &&
            $monFormulaire->isValid()
        ) {
            $entityManager->persist($wish);
            $entityManager->flush();
            $this->addFlash('bravo', 'le formulaire à bien été soumis');
            return $this->redirectToRoute('wish_ajoutFormulaire');
        }
            return $this->renderForm('wish/ajoutFormulaire.html.twig',
               compact('monFormulaire')
            );
        }

}