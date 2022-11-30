<?php

namespace App\Controller;

use App\Entity\Report;
use App\Entity\Article;
use App\Form\ReportFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/{object}/rapport', name: 'report', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, $object): Response
    {
        $report = new Report();
        $form = $this->createForm(ReportFormType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($object instanceof Article) {
                $report->setArticle($object);
            }
            $entityManager->persist($report);
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/index.html.twig', [
            'report' => $report,
            'reportForm' => $form,
            'object' => $object
        ]);
    }
}
