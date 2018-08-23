<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Team;
use App\Form\GameType;
use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game")
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="game_index", methods="GET")
     *
     *
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', ['games' => $gameRepository->findAll()]);
    }

    /**
     *
     * Created by PhpStorm.
     * User: Mateusz Poniatowski <mateusz@live.hk
     * @param Request $request
     * @return Response
     */


    /**
     * @Route("/new", name="game_new", methods="GET|POST")
     * @Security("is_granted('ROLE_ADMIN')")
     */


    public function new(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($game->getFirstTeam() != $game->getSecondTeam()) {
                $game->setFlaga(1);
            } else {
                $game->setFlaga(0);
            }
            if ($game->isFlaga() == false) {
                echo '<script language="javascript">';
                echo 'alert("Wyslano dane")';
                echo '</script>';
                //$this->redirectToRoute('game_new');
            } else {
                $em = $this->getDoctrine()->getManager();


                $datagry = $game->getGameDate();

                $result = $datagry->format('Y-m-d H-i-s');

                $spotkanie1 = $game->getFirstTeam();
                $spotkanie2 = $game->getSecondTeam();
                $spotkanie3 = $spotkanie1 . "-" . $spotkanie2 . " data spotkania: " . $result;
                $game->setMeeting($spotkanie3);

                $em->persist($game);
                $em->flush();
                return $this->redirectToRoute('game_index');
            }
        }
        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_show", methods="GET")
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', ['game' => $game]);
    }


    /**
     *
     * Created by PhpStorm.
     * User: Mateusz Poniatowski <mateusz@live.hk
     * @param Request $request
     * @param Game $game
     * @return Response
     */


    /**
     * @Route("/{id}/edit", name="game_edit", methods="GET|POST")
     * @Security("is_granted('ROLE_ADMIN')")
     */


    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $EntityManager = $this->getDoctrine()->getManager();

            $datagry = $game->getGameDate();

            $result = $datagry->format('Y-m-d H-i-s');

            $spotkanie1 = $game->getFirstTeam();
            $spotkanie2 = $game->getSecondTeam();
            $spotkanie3 = $spotkanie1 . "-" . $spotkanie2 . " data spotkania: " . $result;
            $game->setMeeting($spotkanie3);
            $EntityManager->persist($game);
            $EntityManager->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('game_index', ['id' => $game->getId()]);
        }
        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }



    /**
     *
     * Created by PhpStorm.
     * User: Ania Biała <anna.biala94@wp.pl>
     * Date: 2018-08-22
     * Time: 15:02
     * @param Request $request
     * @param Game $game
     * @return Response
     */
    /**
     * @Route("/{id}", name="game_delete", methods="DELETE")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete' . $game->getId(), $request->request->get('_token'))) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($game);
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {

                return $this->render('bundles/TwigBundle/Exception/errorDel.html.twig', array('status_link' => "game1_index"));
            }
        }
        return $this->redirectToRoute('game1_index');
    }


}