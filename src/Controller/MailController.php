<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('/mail', name: 'mail')]
    public function index(): Response
    {
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

    #[Route('/mail/{nom}', name: 'mail_sendMail')]
    public function sendMail(
        $nom,
        MailerInterface $mailer

    ): Response
    {
        $email = (new Email())
        ->from('sgobin@eni.fr')
        ->to($nom.'@eni.fr')
        ->subject('convocation tribunal')
        ->text('ah ba nan fait c\'était pas pour vous')
    ;
        $mailer->send($email);
        $this->addFlash("mail", "mail envoyé");
        return $this->render('mail/index.html.twig',

        );
    }
}
