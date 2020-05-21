<?php

namespace App\Controller;

use App\Repository\EnvironmentRepository;
use App\Repository\MustacheRepository;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/{id}/editeur", name="editeur")
     */
    public function index(RessourceRepository $ressourceRepository, $id, MustacheRepository $mustacheRepository) {
        $css = $ressourceRepository->findByType('css');
        $mustache = $mustacheRepository->find($id);
        return $this->render('home/index.html.twig', ['css' => $css, 'mustache' => $mustache]);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(EnvironmentRepository $environmentRepository): Response {
        return $this->render('environment/index.html.twig', [
                    'environments' => $environmentRepository->findAll(),
        ]);
    }

}
