<?php

namespace App\Controller;

use App\Entity\ExpectedResults;
use App\Entity\Game;
use App\Form\ExpectedResults10Type;
use App\Repository\ExpectedResultsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("/", name="expected_results_index", methods="GET")
     */
    public function index(ExpectedResultsRepository $expectedResultsRepository): Response
    {



        $repository1=$this->getDoctrine()->getRepository(ExpectedResults::class);
        $repository2=$this->getDoctrine()->getRepository(Game::class);
        $numberofmatch = $repository1->createQueryBuilder('u') // aktualnie to ilosc obstawionych meczy,

        ->select('u.id')
            ->getQuery();
        $numberofmatch=$numberofmatch->execute(); //id wszystkich obstawionych meczy
        $expectedResult = new ExpectedResults();


//dump($numberofmatch);die;
        $licznik=1;
        $entityManager = $this->getDoctrine()->getManager();
       foreach($numberofmatch as $x){

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

           $datatype=$expectedResult->getDateOfType();
           $datagame=$expectedResult->getGameDateId();
           $stanFlagi=$expectedResult->getFlaga();


           //$expectedResult->getNameOfMeeting()->getTournament();//id turnieju
           $waga=$expectedResult->getNameOfMeeting()->getTypeofWeight();//waga meczu
           $realfirstscore = $expectedResult->getNameOfMeeting()->getFirstTeamScore();//gole 1 zespolu
           $realsecondscore = $expectedResult->getNameOfMeeting()->getSecondTeamScore();// gole 2 zespolu
           $expfirstscore = $expectedResult->getFirstTeamScoreExpected();//przewidywane gole 1 zespolu
           $expsecondscore = $expectedResult->getSecondTeamScoreExpected();
         //  dump($realfirstscore);die;

          if($datatype<$datagame){ //JEZELI data gry jest pozniejsza niz obstawienia rob punkty
              if($stanFlagi==false){ //naliczaj punkty jezeli nie byl sprawdzany dane obstawienie

                    if($realfirstscore==$expfirstscore && $realsecondscore==$expsecondscore){ //jezeli idealnie trafił wynik

                        $expectedResult->setPoints(3);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();



                    }elseif($realfirstscore>$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore!=$expsecondscore)
                            { //uzytkownik trafił wygrana 1 teamu nie trafil w gole

                                    $expectedResult->setPoints(1);
                                    $expectedResult->setFlaga(true);
                                $entityManager->persist($expectedResult);
                                $entityManager->flush();

                            }elseif ($realfirstscore<$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore!=$expsecondscore){
                        //uzytkownik trafił wygrana 2 teamu nie trafil w gole
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    }elseif ($realsecondscore==$realfirstscore && $expsecondscore==$expfirstscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore!=$expsecondscore){
                        //trafił remis nie trafil ilosci goli

                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();


                    }elseif ($realsecondscore==$realfirstscore && $expsecondscore==$expfirstscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore){
                        //trafił remis i trafil gola po jednej stronie +1pkt
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    }elseif ($realsecondscore==$realfirstscore && $expsecondscore==$expfirstscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore){
                        //trafil remis i jednego gola + 1 pkt
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    } elseif($realfirstscore>$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                    { //uzytkownik trafił wygrana 1 teamu i trafil jednego gola

                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    }elseif($realfirstscore>$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                    { //uzytkownik trafił wygrana 1 teamu i trafil gola

                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    }elseif ($realfirstscore<$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore){
                        //uzytkownik trafił wygrana 2 teamu i trafil  gola dla  teamu
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    }elseif ($realfirstscore<$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore){
                        //uzytkownik trafił wygrana 2 teamu i trafil  gola dla  teamu
                        $expectedResult->setPoints(2);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();

                    }elseif ($realfirstscore<$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                    //przegrala 1 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore<$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                        //przegrala 1 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore>$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                        //przegrala 2 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore>$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                        //przegrala 2 druzyna user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore==$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                        //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore==$realsecondscore && $expfirstscore<$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                        //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore==$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                        //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }elseif ($realfirstscore==$realsecondscore && $expfirstscore>$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                        //był remis ale user obstawil inaczej ale trafil gola dla jednego teamu
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }//byla porazka ale on obstawil remis
                    elseif ($realfirstscore>$realsecondscore && $expfirstscore==$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                         {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                             $entityManager->persist($expectedResult);
                             $entityManager->flush();
                    } elseif ($realfirstscore>$realsecondscore && $expfirstscore==$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                        //była porażka a user obstawil remis
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    } elseif ($realfirstscore<$realsecondscore && $expfirstscore==$expsecondscore
                        && $realfirstscore!=$expfirstscore && $realsecondscore==$expsecondscore)
                        {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                            $entityManager->persist($expectedResult);
                            $entityManager->flush();
                    }elseif ($realfirstscore<$realsecondscore && $expfirstscore==$expsecondscore
                        && $realfirstscore==$expfirstscore && $realsecondscore!=$expsecondscore)
                    {
                        $expectedResult->setPoints(1);
                        $expectedResult->setFlaga(true);
                        $entityManager->persist($expectedResult);
                        $entityManager->flush();
                    }else{


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
        $expectedResult1=new Game();
        $form = $this->createForm(ExpectedResults10Type::class, $expectedResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository1=$this->getDoctrine()->getRepository(Game::class);

            $meeting=$expectedResult->getNameOfMeeting();


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

            $expectedResult->setDateOfType(\DateTime::createFromFormat( 'Y-m-d H-i-s' ,date('Y-m-d H-i-s')));
            $this->getDoctrine()->getManager();

            $this->persist($expectedResult);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expected_results_edit', ['id' => $expectedResult->getId()]);
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
        if ($this->isCsrfTokenValid('delete'.$expectedResult->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expectedResult);
            $em->flush();
        }

        return $this->redirectToRoute('expected_results_index');
    }

}
