<?php

namespace App\Controller;

use App\Entity\ExpectedResults;
use App\Entity\Game;
use App\Form\ExpectedResults10Type;
use App\Repository\ExpectedResultsRepository;
use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/expected/results")
 */
class ExpectedResultsController extends Controller
{


    /**
     *
     * Created by PhpStorm.
     * User: Mateusz Poniatowski <mateusz@live.hk
     * @param ExpectedResultsRepository $expectedResultsRepository
     * @return Response
     */






    /**
     * @Route("/gametotype/{id}", name="game1_show",  methods="GET|POST")
     * @Security("is_granted('ROLE_USER')")
     */
    public function show1(Game $game,Request $request): Response
    {

        $repository1=$this->getDoctrine()->getRepository(Game::class);
        $repository2=$this->getDoctrine()->getRepository(ExpectedResults::class);



        $expectedResult = new ExpectedResults();
        $expectedResult1=new Game();
        $form = $this->createForm(ExpectedResults10Type::class, $expectedResult);
        $form->handleRequest($request);






        $numberofmatch1 = $repository1->createQueryBuilder('u') // aktualnie to ilosc obstawionych meczy,
        ->select('u.id')
            ->getQuery();
        $numberofmatch1=$numberofmatch1->execute(); //id wszystkich obstawionych meczy


        $title = $request->attributes->get('id');
        $title=(int)$title;//mam id gry z GAME!!! a chce miec
//dump($title);die;

        $numberoflastid = $repository1->createQueryBuilder('u') // aktualnie to ilosc obstawionych meczy,
        ->select('u.id')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        $numberoflastid=$numberoflastid->execute();
        $lastIdInGame;
        foreach ($numberoflastid as $a){

            $lastIdInGame=$a['id'];
        }
        $numberofmatch = $repository1->createQueryBuilder('u') // wybor nazwy spotkania
        ->select('u.meeting')
            ->andWhere('u.id = :id')
            ->setParameter('id', $title)
            ->getQuery();
        $numberofmatch=$numberofmatch->execute(); //mamy nazwe spotkania!)



$nameofmatch;
        foreach ($numberofmatch as $a){

            $nameofmatch=$a['meeting'];
            //dump($nameofmatch);die;//konkretna nazwa spotkania!!! to porównywać z tym co jest w formularzu !!!
        }






        $GameInstance = new Game();


        if ($form->isSubmitted() && $form->isValid()) {


            foreach ($numberofmatch1 as $i){


                $expectedResult1 = $repository1->find($i['id']);//najważniejsze!!!
              //
                if($i['id']==$title){ // id gry rowne id konkretnej gry
                    //pobrac ostatnie id z expected i dodac 1
                    //$expectedResult = $repository1->findById($id);

                //    dump($expectedResult1->getMeeting());die;

                  //  dump($expectedResult->setNameOfMeeting($expectedResult1->getMeeting()));die;
                   // $expectedResult = $repository2->findById($lastIdInGame);

               //     $expectedResult->setNameOfMeeting($expectedResult1->getMeeting());
                //    $expectedResult->setGameDateId($expectedResult1->getGameDate());
                 /*   $numberofmatch = $repository1->createQueryBuilder('u') // wybor nazwy spotkania
                    ->select('u.meeting')
                        ->andWhere('u.id = :id')
                        ->setParameter('id', $i)
                        ->getQuery();
                    $numberofmatch=$numberofmatch->execute(); //mamy nazwe spotkania!
*/


                    //    $GameInstance->setMeeting($numberofmatch);

                }


            }



            $meeting=$expectedResult->getNameOfMeeting();



//$expectedResult->setNameOfMeeting($GameInstance->getMeeting());
            $expectedResult->setDateOfType(\DateTime::createFromFormat( 'Y-m-d H-i-s' ,date('Y-m-d H-i-s')));


            $em = $this->getDoctrine()->getManager();




            $em->persist($expectedResult);
            $em->flush();
            $EntityManager=$this->getDoctrine()->getManager();

            /*
            $expectedResult->getNameOfMeeting()->getTournament();//id turnieju
            $expectedResult->getDateOfType(); //data typowania
            $expectedResult->getNameOfMeeting()->getTypeofWeight();//waga meczu
            $expectedResult->getFlaga();//stan flagi
            $expectedResult->getNameOfMeeting()->getFirstTeamScore();//gole 1 zespolu
            $expectedResult->getNameOfMeeting()->getSecondTeamScore();// gole 2 zespolu
            $expectedResult->getFirstTeamScoreExpected();//przewidywane gole 1 zespolu
            $expectedResult->getSecondTeamScoreExpected();///przewidywane gole 2 zespolu
        */


            $expectedResult->setUserId($this->getUser());
            //   dump($expectedResult->getNameOfMeeting()->getGameDate());die;
//$expectedResult1->setGameDate($expectedResult->getNameOfMeeting()->getGameDate());
            // dump($expectedResult1->getGameDate());die;
//$expectedResult->setGameDateId($expectedResult1->getGameDate());

            $EntityManager->persist($expectedResult);
            $EntityManager->flush();
            return $this->redirectToRoute('expected_results_index');
        }

        return $this->render('expected_results/showgametotype.html.twig', ['game' => $game,
            'expected_result' => $expectedResult,
            'form' => $form->createView(),
        ]);
    }






    /**
     * @Route("/", name="expected_results_index", methods="GET")
     */


    public function index(ExpectedResultsRepository $expectedResultsRepository): Response
    {


        $repository1 = $this->getDoctrine()->getRepository(ExpectedResults::class);
        $repository2 = $this->getDoctrine()->getRepository(Game::class);
        $numberofmatch = $repository1->createQueryBuilder('u')// aktualnie to ilosc obstawionych meczy,

        ->select('u.id')
            ->getQuery();
        $numberofmatch = $numberofmatch->execute(); //id wszystkich obstawionych meczy
        $expectedResult = new ExpectedResults();


//dump($numberofmatch);die;
        $licznik = 1;
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($numberofmatch as $x) {

            $expectedResult = $repository1->find($x['id']);//najważniejsze!!!

            /* $datetype = $repository1->createQueryBuilder('a') // aktualnie to ilosc obstawionych meczy,
             ->select('a.DateOfType')
                 ->andWhere('a.id = :id')
                 ->setParameter('id',$x['id'] )
                 ->getQuery();

             $datetype=$datetype->execute();//data typu dla danego id

             $datagame=$repository1->createQueryBuilder('b') // aktualnie to ilosc obstawionych meczy,
  ->select('b.Game_date_id')
      ->andWhere('b.id = :id')
      ->setParameter('id', $x['id'])
      ->getQuery();

             $datagame=$datagame->execute();

             $stanFlagi= $repository1->createQueryBuilder('c') // flage
             ->select('c.Flaga')
                 ->andWhere('c.id = :id')
                 ->setParameter('id',$x['id'] )
                 ->getQuery();
             $stanFlagi=$stanFlagi->execute();





             foreach ($stanFlagi as $a){

                      $stanFlagi=$a['Flaga'];

             }




  //if($datagame>$datetype){ //czy czas gry jest pozniej ustawiony niz data typu
  */

            $datatype = $expectedResult->getDateOfType();
            $datagame = $expectedResult->getGameDateId();
            $stanFlagi = $expectedResult->getFlaga();


            //$expectedResult->getNameOfMeeting()->getTournament();//id turnieju
            $waga = $expectedResult->getNameOfMeeting()->getTypeofWeight();//waga meczu
            $realfirstscore = $expectedResult->getNameOfMeeting()->getFirstTeamScore();//gole 1 zespolu
            $realsecondscore = $expectedResult->getNameOfMeeting()->getSecondTeamScore();// gole 2 zespolu
            $expfirstscore = $expectedResult->getFirstTeamScoreExpected();//przewidywane gole 1 zespolu
            $expsecondscore = $expectedResult->getSecondTeamScoreExpected();
            //  dump($realfirstscore);die;

            if ($datatype < $datagame && $realfirstscore != NULL && $realsecondscore != NULL) { //JEZELI data gry jest pozniejsza niz obstawienia rob punkty
                if ($stanFlagi == false) { //naliczaj punkty jezeli nie byl sprawdzany dane obstawienie

                    if ($realfirstscore == $expfirstscore && $realsecondscore == $expsecondscore) { //jezeli idealnie trafił wynik

                        $expectedResult->setPoints(3);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();


                    } elseif ($realfirstscore > $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore != $expsecondscore) { //uzytkownik trafił wygrana 1 teamu nie trafil w gole

                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore != $expsecondscore) {
                        //uzytkownik trafił wygrana 2 teamu nie trafil w gole
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realsecondscore == $realfirstscore && $expsecondscore == $expfirstscore
                        && $realfirstscore != $expfirstscore && $realsecondscore != $expsecondscore) {
                        //trafił remis nie trafil ilosci goli

                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();


                    } elseif ($realsecondscore == $realfirstscore && $expsecondscore == $expfirstscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) {
                        //trafił remis i trafil gola po jednej stronie +1pkt
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realsecondscore == $realfirstscore && $expsecondscore == $expfirstscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) {
                        //trafil remis i jednego gola + 1 pkt
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realfirstscore > $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) { //uzytkownik trafił wygrana 1 teamu i trafil jednego gola

                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realfirstscore > $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) { //uzytkownik trafił wygrana 1 teamu i trafil gola

                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) {
                        //uzytkownik trafił wygrana 2 teamu i trafil  gola dla  teamu
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) {
                        //uzytkownik trafił wygrana 2 teamu i trafil  gola dla  teamu
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) //przegrala 1 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) //przegrala 1 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore > $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) //przegrala 2 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore > $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) //przegrala 2 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore == $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore == $realsecondscore && $expfirstscore < $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore == $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore == $realsecondscore && $expfirstscore > $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }//byla porazka ale on obstawil remis
                    elseif ($realfirstscore > $realsecondscore && $expfirstscore == $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore > $realsecondscore && $expfirstscore == $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) //była porażka a user obstawil remis
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore == $expsecondscore
                        && $realfirstscore != $expfirstscore && $realsecondscore == $expsecondscore) {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore < $realsecondscore && $expfirstscore == $expsecondscore
                        && $realfirstscore == $expfirstscore && $realsecondscore != $expsecondscore) {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } else {


                        $expectedResult->setPoints(0);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();


                    }


                }


            }


        }


        return $this->render('expected_results/index.html.twig', ['expected_results' => $expectedResultsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="expected_results_new", methods="GET|POST")
     * @Security("is_granted('ROLE_USER')")
     */
    public function new(Request $request): Response
    {
        $expectedResult = new ExpectedResults();
        $expectedResult1 = new Game();
        $form = $this->createForm(ExpectedResults10Type::class, $expectedResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository1 = $this->getDoctrine()->getRepository(Game::class);

            $meeting = $expectedResult->getNameOfMeeting();


            $expectedResult->setDateOfType(\DateTime::createFromFormat('Y-m-d H-i-s', date('Y-m-d H-i-s')));
            $em = $this->getDoctrine()->getManager();

            $em->persist($expectedResult);
            $em->flush();
            $EntityManager = $this->getDoctrine()->getManager();

            /*
            $expectedResult->getNameOfMeeting()->getTournament();//id turnieju
            $expectedResult->getDateOfType(); //data typowania
            $expectedResult->getNameOfMeeting()->getTypeofWeight();//waga meczu
            $expectedResult->getFlaga();//stan flagi
            $expectedResult->getNameOfMeeting()->getFirstTeamScore();//gole 1 zespolu
            $expectedResult->getNameOfMeeting()->getSecondTeamScore();// gole 2 zespolu
            $expectedResult->getFirstTeamScoreExpected();//przewidywane gole 1 zespolu
            $expectedResult->getSecondTeamScoreExpected();///przewidywane gole 2 zespolu
*/


            $expectedResult->setUserId($this->getUser());
            //   dump($expectedResult->getNameOfMeeting()->getGameDate());die;
            $expectedResult1->setGameDate($expectedResult->getNameOfMeeting()->getGameDate());
            // dump($expectedResult1->getGameDate());die;
            $expectedResult->setGameDateId($expectedResult1->getGameDate());

            $EntityManager->persist($expectedResult);
            $EntityManager->flush();
            return $this->redirectToRoute('expected_results_index');
        }

        return $this->render('expected_results/new.html.twig', [
            'expected_result' => $expectedResult,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/gametotype", name="game1_index", methods="GET")
     *
     */
    public function index1(GameRepository $gameRepository): Response
    {
        return $this->render('expected_results/gamestotype.html.twig', ['games' => $gameRepository->findAll()]);
    }





    /**
     * @Route("/{id}", name="expected_results_show", methods="GET")
     */
    public function show(ExpectedResults $expectedResult): Response
    {


        return $this->render('expected_results/show.html.twig', ['expected_result' => $expectedResult]);
    }

    /**
     * @Route("/{id}/edit", name="expected_results_edit", methods="GET|POST")
     * @Security("is_granted('ROLE_USER')")
     */
    public function edit(Request $request, ExpectedResults $expectedResult): Response
    {
        $form = $this->createForm(ExpectedResults10Type::class, $expectedResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $expectedResult->setDateOfType(\DateTime::createFromFormat('Y-m-d H-i-s', date('Y-m-d H-i-s')));
            $this->getDoctrine()->getManager();

           // $this->persist($expectedResult);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expected_results_index', ['id' => $expectedResult->getId()]);
        }

        return $this->render('expected_results/edit.html.twig', [
            'expected_result' => $expectedResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expected_results_delete", methods="DELETE")
     * @Security("is_granted('ROLE_USER')")
     */
    public function delete(Request $request, ExpectedResults $expectedResult): Response
    {
        if ($this->isCsrfTokenValid('delete' . $expectedResult->getId(), $request->request->get('_token'))) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($expectedResult);
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {

                return $this->render('bundles/TwigBundle/Exception/errorDel.html.twig', array('status_link' => "expected_results_index"));
            }
        }

        return $this->redirectToRoute('expected_results_index');
    }
}
