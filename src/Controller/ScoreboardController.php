<?php

namespace App\Controller;

use App\Entity\Scoreboard;
use App\Form\ScoreboardType;
use App\Repository\ScoreboardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/scoreboard")
 */
class ScoreboardController extends Controller
{
    /**
     * @Route("/", name="scoreboard_index", methods="GET")
     */
    public function index(ScoreboardRepository $scoreboardRepository): Response
    {
        return $this->render('scoreboard/index.html.twig', ['scoreboards' => $scoreboardRepository->findAll()]);
    }

    /**
     * @Route("/new", name="scoreboard_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $scoreboard = new Scoreboard();
        $form = $this->createForm(ScoreboardType::class, $scoreboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scoreboard);
            $em->flush();

            return $this->redirectToRoute('scoreboard_index');
        }

        return $this->render('scoreboard/new.html.twig', [
            'scoreboard' => $scoreboard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scoreboard_show", methods="GET")
     */
    public function show(Scoreboard $scoreboard): Response
    {
        return $this->render('scoreboard/show.html.twig', ['scoreboard' => $scoreboard]);
    }

    /**
     * @Route("/{id}/edit", name="scoreboard_edit", methods="GET|POST")
     */
    public function edit(Request $request, Scoreboard $scoreboard): Response
    {
        $form = $this->createForm(ScoreboardType::class, $scoreboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scoreboard_edit', ['id' => $scoreboard->getId()]);
        }

        return $this->render('scoreboard/edit.html.twig', [
            'scoreboard' => $scoreboard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scoreboard_delete", methods="DELETE")
     */
    public function delete(Request $request, Scoreboard $scoreboard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scoreboard->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scoreboard);
            $em->flush();
        }

        return $this->redirectToRoute('scoreboard_index');
    }
}
