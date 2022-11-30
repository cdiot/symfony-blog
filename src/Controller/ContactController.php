<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->addFlash('notice', 'Message envoyé ! Je vous répondrai dans les plus brefs délais.');
            $mailer->send(
                $data['subject'],
                $data['email'],
                'contact@ryokosan.com',
                'emails/contact.html.twig',
                [
                    'content' => $data['content'],
                ]
            );
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
