<?php
namespace App\Controller;
use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
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
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', ['games' => $gameRepository->findAll()]);
    }
    /**
     * @Route("/new", name="game_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($game->getFirstTeam()!=$game->getSecondTeam()){
                $game->setFlaga(1);
            }else{
                $game->setFlaga(0);
            }
            if($game->isFlaga()==false){
                echo '<script language="javascript">';
                echo 'alert("message successfully sent")';
                echo '</script>';
                //$this->redirectToRoute('game_new');
            }else{
                $em = $this->getDoctrine()->getManager();

                $spotkanie1=$game->getFirstTeam();
                $spotkanie2=$game->getSecondTeam();
                $spotkanie3=$spotkanie1."-".$spotkanie2;
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
     * @Route("/{id}/edit", name="game_edit", methods="GET|POST")
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $EntityManager=$this->getDoctrine()->getManager();


            $spotkanie1=$game->getFirstTeam();
            $spotkanie2=$game->getSecondTeam();
            $spotkanie3=$spotkanie1."-".$spotkanie2;
            $game->setMeeting($spotkanie3);
            $EntityManager->persist($game);
            $EntityManager->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('game_edit', ['id' => $game->getId()]);
        }
        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="game_delete", methods="DELETE")
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }
        return $this->redirectToRoute('game_index');
    }
}