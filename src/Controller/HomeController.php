<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/article/{id}', name: 'show_article')]
    public function show(int $id): Response
    {
        return new Response('Article ' . $id);

    }

    #[Route('/profil/{nom}', name: 'profil', defaults: ['nom' => 'visiteur'])]
    public function profil(string $nom): Response
    {
        return new Response("Bonjour $nom");

    }

    #[Route('/produit/{id}', name: 'produit', requirements: ['id' => '\d+'])]
    public function produit(int $id): Response
    {
        return new Response("Produit n° $id");

    }

    #[Route('/contact', name: 'contact', methods: ['POST'])]
    public function contact(Request $request): Response {
        return new Response('Message reçu : ' . $request->get('message'));
    }

    #[Route('/go-to-home', name: 'goto_home')]
    public function redirectToHome(): Response {
        return $this->redirectToRoute('profil');
    }
}
