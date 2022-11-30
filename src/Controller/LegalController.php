<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/politique-de-confidentialite', name: 'privacy')]
    public function privacy(): Response
    {
        return $this->render('legal/privacy.html.twig');
    }

    #[Route('/conditions-generales-utilisation', name: 'terms')]
    public function terms(): Response
    {
        return $this->render('legal/terms.html.twig');
    }
}
