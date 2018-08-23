<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\Tournament1Type;
use App\Repository\TournamentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tournament")
 */
class TournamentController extends Controller
{
    /**
     * @Route("/", name="tournament_index", methods="GET")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(TournamentRepository $tournamentRepository): Response
    {
        return $this->render('tournament/index.html.twig', ['tournaments' => $tournamentRepository->findAll()]);
    }

    /**
     * @Route("/new", name="tournament_new", methods="GET|POST")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function new(Request $request): Response
    {
        $tournament = new Tournament();
        $form = $this->createForm(Tournament1Type::class, $tournament);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournament);
            $em->flush();
            return $this->redirectToRoute('tournament_index');
        }
        return $this->render('tournament/new.html.twig', [
            'tournament' => $tournament,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tournament_show", methods="GET")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function show(Tournament $tournament): Response
    {
        return $this->render('tournament/show.html.twig', ['tournament' => $tournament]);
    }

    /**
     * @Route("/{id}/edit", name="tournament_edit", methods="GET|POST")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Tournament $tournament): Response
    {
        $form = $this->createForm(Tournament1Type::class, $tournament);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tournament_index', ['id' => $tournament->getId()]);
        }
        return $this->render('tournament/edit.html.twig', [
            'tournament' => $tournament,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tournament_delete", methods="DELETE")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Tournament $tournament): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tournament->getId(), $request->request->get('_token'))) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($tournament);
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {

                return $this->render('bundles/TwigBundle/Exception/errorDel.html.twig', array('status_link' => "tournament_index"));
            }
        }
        return $this->redirectToRoute('tournament_index');
    }
}