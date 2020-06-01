<?php

namespace App\Controller;

use App\Entity\Attachment;
use App\Form\AttachmentType;
use App\Repository\MustacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ZipArchive;

class HomeController extends AbstractController {

    /**
     * @Route("/{id}/home", name="home")
     */
    public function index(MustacheRepository $mustacheRepository, $id) {
        $mustache = $mustacheRepository->find($id);

        $f = $mustache->getRessources();

        $arr = array();
        foreach ($f as $i => $item) {
            $arr[] = $item;
        }
        $zipName = $mustache->getName() . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($zipName, ZipArchive::CREATE)) {
            foreach ($arr as $i => $item) {

                $filename = $item->getName() . '.' . $item->getType();
                $zip->addFromString($filename, $item->getContent());
            }
            $zip->close();

            $response = new Response(file_get_contents($zipName));
            $response->headers->set('Content-Type', 'application/zip');
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
            $response->headers->set('Content-length', filesize($zipName));

            @unlink($zipName);

            return $response;
        }
    }

    /**
     * @Route("/attachment/{id}/new", name="attachment_new")
     */
    public function new(Request $request, MustacheRepository $mustacheRepository, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $attachment = new Attachment();
        $form = $this->createForm(AttachmentType::class, $attachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mustache = $mustacheRepository->find($id);
            $attachment->setMustache($mustache);
            $entityManager->persist($attachment);
            $entityManager->flush();

            return $this->redirectToRoute('environment_show', ['id' => $mustache->getEnvironment()->getId()]);
        }

        return $this->render('environment/file_form.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
