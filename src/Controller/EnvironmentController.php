<?php

namespace App\Controller;

use App\Entity\Environment;
use App\Form\EnvironmentType;
use App\Repository\EnvironmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/environment")
 */
class EnvironmentController extends AbstractController {

    /**
     * @Route("/", name="environment_index", methods={"GET"})
     */
    public function index(EnvironmentRepository $environmentRepository): Response {
        return $this->render('environment/index.html.twig', [
                    'environments' => $environmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="environment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $environment = new Environment();
        $form = $this->createForm(EnvironmentType::class, $environment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($environment);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('environment/new.html.twig', [
                    'environment' => $environment,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="environment_show", methods={"GET"})
     */
    public function show(Environment $environment): Response {
        return $this->render('environment/show.html.twig', [
                    'environment' => $environment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="environment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Environment $environment): Response {
        $form = $this->createForm(EnvironmentType::class, $environment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('environment/edit.html.twig', [
                    'environment' => $environment,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="environment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Environment $environment): Response {
        if ($this->isCsrfTokenValid('delete' . $environment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($environment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

}
