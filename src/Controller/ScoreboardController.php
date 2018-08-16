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


        $repository=$this->getDoctrine()->getRepository(Scoreboard::class);
        $repository1=$this->getDoctrine()->getRepository(ExpectedResults::class);
        $repository2=$this->getDoctrine()->getRepository(Game::class);


        //zapis punktów dla użytkownika
        $entityManager=$this->getDoctrine()->getManager();

        $numberofusers = $repository1->createQueryBuilder('u') // aktualnie to ilosc obstawionych meczy, trzeba zmienic na konkretnego użytkownika
        ->select('* u.user_id_id')
            ->getQuery()
            ->getSingleScalarResult();





foreach ($numberofusers as $x){  // ta petla bedzie prawidlowo zapisywac po bedzie po tablicy isc



    $query2 = $repository2->createQueryBuilder('b')
        ->select("b.date_of_type")
        ->andWhere('b.name_of_meeting =: id_typera')
        ->setParameter('id_typera',$x)
        ->getQuery();


            /*  $query = $repository1->createQueryBuilder('p')
      ->select("p.date_of_type")
      ->andWhere('p.id_obstawiajacego =: id_obstawiajacego')
      ->setParameter('id_obstawiajacego',$x)
      ->getQuery();
*/
            $entityManager = $this->getDoctrine()->getManager();
            $expectedResult = $entityManager->getRepository(ExpectedResults::class)->find($x);

            //        if($query < $guery2 ){ // jesli data pozniejsza nie zapisuj

//kolejny if czy bylo sprawdzane, jak tak to nie wchodzi do zapisywania, czyli czy expectedResult->getFlagaSprawdzenia() == true to wtedy nie zapisuje




            $Result=$entityManager->getRepository(Game::class)->findAll($x);//trzeba znależć po id meczu a nie id uzytkownika
//            $Result->get
            $scoreboards=new Scoreboard();
            $scoreboards->setPoints(3);


            $expectedResult->setFlagaSprawdzenia(true);
            $entityManager->flush();

            // $scoreboards->setTournament("Ekstraklasa Polska");
            //$scoreboards->setUser(1);

            $entityManager->persist($scoreboards);
            $entityManager->flush();

                       }





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
