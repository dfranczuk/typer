<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class TeamController extends Controller
{
    /**
     * @Route("/", name="team_index", methods="GET")
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', ['teams' => $teamRepository->findAll()]);
    }

    /**
     * @Route("/new", name="team_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods="GET")
     */
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', ['team' => $team]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods="GET|POST")
     */
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_index', ['id' => $team->getId()]);
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods="DELETE")
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($team);
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {

                return $this->render('bundles/TwigBundle/Exception/errorDel.html.twig', array('status_link' => "team_index"));
            }
        }


        return $this->redirectToRoute('team_index');
    }
}
