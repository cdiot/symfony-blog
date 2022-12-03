<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\User;
use App\Form\Type\WelcomeFormType;
use App\Repository\ArticleRepository;
use App\Repository\OptionRepository;
use App\Service\Welcome;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'lastArticles' => $articleRepository->findLast(),
            'popularArticles' => $articleRepository->findPopular(),
        ]);
    }

    #[Route('/bienvenue', name: 'welcome')]
    public function welcome(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        OptionRepository $optionRepository
    ): Response {
        if ($optionRepository->getValue(Welcome::SITE_INSTALLED_NAME)) {
            return $this->redirectToRoute('home');
        }

        $welcomeForm = $this->createForm(WelcomeFormType::class, new Welcome());

        $welcomeForm->handleRequest($request);

        if ($welcomeForm->isSubmitted() && $welcomeForm->isValid()) {
            /** @var Welcome $data */
            $data = $welcomeForm->getData();

            $siteInstalled = new Option();
            $siteInstalled->setLabel(Welcome::SITE_INSTALLED_LABEL);
            $siteInstalled->setName(Welcome::SITE_INSTALLED_NAME);
            $siteInstalled->setValue(true);

            $user = new User();
            $user->setEmail($data->getEmail());
            $user->setPassword($passwordHasher->hashPassword($user, $data->getPassword()));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setUsername($data->getUsername());
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setUpdatedAt(new DateTime());
            $user->setIsVerified(true);

            $entityManager->persist($siteInstalled);

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/welcome.html.twig', [
            'form' => $welcomeForm->createView()
        ]);
    }
}
