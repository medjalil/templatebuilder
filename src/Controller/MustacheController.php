<?php

namespace App\Controller;

use App\Entity\Mustache;
use App\Form\MustacheType;
use App\Repository\MustacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mustache")
 */
class MustacheController extends AbstractController
{
    /**
     * @Route("/", name="mustache_index", methods={"GET"})
     */
    public function index(MustacheRepository $mustacheRepository): Response
    {
        return $this->render('mustache/index.html.twig', [
            'mustaches' => $mustacheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mustache_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mustache = new Mustache();
        $form = $this->createForm(MustacheType::class, $mustache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mustache);
            $entityManager->flush();

            return $this->redirectToRoute('mustache_index');
        }

        return $this->render('mustache/new.html.twig', [
            'mustache' => $mustache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mustache_show", methods={"GET"})
     */
    public function show(Mustache $mustache): Response
    {
        return $this->render('mustache/show.html.twig', [
            'mustache' => $mustache,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mustache_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mustache $mustache): Response
    {
        $form = $this->createForm(MustacheType::class, $mustache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mustache_index');
        }

        return $this->render('mustache/edit.html.twig', [
            'mustache' => $mustache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mustache_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mustache $mustache): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mustache->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mustache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mustache_index');
    }
}
