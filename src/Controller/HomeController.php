<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Repository\MustacheRepository;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/{id}/home", name="home")
     */
    public function index(RessourceRepository $ressourceRepository, $id, MustacheRepository $mustacheRepository) {
        $css = $ressourceRepository->findByType('css');
        $mustache = $mustacheRepository->find($id);
        return $this->render('home/index.html.twig', ['css' => $css, 'mustache' => $mustache]);
    }

    /**
     * @Route("/css/{id}", name="css_new")
     */
    public function new(Request $request, MustacheRepository $mustacheRepository, $id): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $ressource = new Ressource();
        $m = $mustacheRepository->find($id);
        if ($request->isXmlHttpRequest()) {
            $ressource->setName($request->request->get('name'));
            $ressource->setContent($request->request->get('content'));
            $ressource->setType($request->request->get('type'));
            $ressource->setMustache($m);
            $entityManager->persist($ressource);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/convert", name="pj")
     */
    function printrSourceToJson() {
        $string = 'Array (
            [designation] => Array (
                [id] => 2020_2019
                [rawvalue] => Escargots

            )
        )';
        $string = str_replace('"', '\'', $string);
        /**
         * replacing `stdClass Objects (` to  `{`
         */
        $string = preg_replace("/stdClass Object\s*\(/s", '{  ', $string);

        /**
         * replacing `Array (` to  `{`
         */
        $string = preg_replace("/Array\s*\(/s", '{  ', $string);
        /**
         * replacing `)\n` to  `},\n`
         * @note This might append , at the last of string as well
         * which we will trim later on.
         */
        $string = preg_replace("/\)\n/", "},\n", $string);

        /**
         * replacing `)` to  `}` at the last of string
         */
        $string = preg_replace("/\)$/", '}', $string);

//Il faut aussi supprimer les retours à la ligne qui ne sont pas suivi de 4 espaces minimum '    '
        $string = preg_replace("/([\n\r])(?!    )/", " ", $string);
        /**
         * replacing `[ somevalue ]` to "somevalue"
         */
        $string = preg_replace("/\[\s*([^\s\]]+)\s*\](?=\s*\=>)/", '"\1" ', $string);
        /**
         * replacing `=> {`  to `: {`
         */
        $string = preg_replace("/=>\s*{/", ': {', $string);
        /**
         * replacing empty last values of array special case `=> \n }` to : "" \n
         */
        $string = preg_replace("/=>\s*[\n\s]*\}/s", ":\"\"\n}", $string);

        /**
         * replacing `=> somevalue`  to `: "somevalue",`
         */
        $string = preg_replace("/=>\s*([^\n\"]*)/", ':"\1",', $string);
        /**
         * replacing last mistakes `, }` to `}`
         */
        $string = preg_replace("/,\s*}/s", '}', $string);



        $string = str_replace('<', '\\u003C', $string);
        $string = str_replace('>', '\\u003E', $string);
        $string = str_replace('&', '\\u0026', $string);
        $string = str_replace('\'', '\\u0027', $string);

        $string = preg_replace("/\\\\u003E[\n\r]/", "\\u003E", $string);


        /**
         * replacing `} ,` at the end to `}`
         */
        $string = preg_replace("/}\s*,$/s", '}', $string);



        return new Response($string);
    }

}
