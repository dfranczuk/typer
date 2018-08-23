<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpectedResultsRepository")
 */
class ExpectedResults
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Range(
     *      min = 0,
     *      max = 50,
     *      minMessage = "score.too_small",
     *      maxMessage = "score.too_big"
     * )
     */
    private $FirstTeamScoreExpected;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *  @Assert\Range(
     *      min = 0,
     *      max = 50,
     *      minMessage = "score.too_small",
     *      maxMessage = "score.too_big"
     * )
     */
    private $SecondTeamScoreExpected;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game")
     */
    private $NameOfMeeting;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="expectedResultsID")
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateOfType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Flaga=false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Scoreboard", inversedBy="ExpectedResultsID")
     */
    private $ScoreboardID;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Game_date_id;




    public function getId()
    {
        return $this->id;
    }

    public function getFirstTeamScoreExpected(): ?int
    {
        return $this->FirstTeamScoreExpected;
    }

    public function setFirstTeamScoreExpected(?int $FirstTeamScoreExpected): self
    {
        $this->FirstTeamScoreExpected = $FirstTeamScoreExpected;

        return $this;
    }

    public function getSecondTeamScoreExpected(): ?int
    {
        return $this->SecondTeamScoreExpected;
    }

    public function setSecondTeamScoreExpected(?int $SecondTeamScoreExpected): self
    {
        $this->SecondTeamScoreExpected = $SecondTeamScoreExpected;

        return $this;
    }

    public function getNameOfMeeting(): ?Game
    {
        return $this->NameOfMeeting;
    }

    public function setNameOfMeeting(?Game $NameOfMeeting): self
    {
        $this->NameOfMeeting = $NameOfMeeting;

        return $this;
    }



    public function getUserId(): User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): void
    {
        $this->user_id = $user_id;

    }

    public function getDateOfType(): ?\DateTimeInterface
    {
        return $this->DateOfType;
    }

    public function setDateOfType(\DateTimeInterface $DateOfType): self
    {
        $this->DateOfType = $DateOfType;

        return $this;
    }

    public function getFlaga(): ?bool
    {
        return $this->Flaga;
    }

    public function setFlaga(bool $Flaga): self
    {
        $this->Flaga = $Flaga;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getScoreboardID(): ?Scoreboard
    {
        return $this->ScoreboardID;
    }

    public function setScoreboardID(?Scoreboard $ScoreboardID): self
    {
        $this->ScoreboardID = $ScoreboardID;

        return $this;
    }

    public function getGameDateId(): ?\DateTimeInterface
    {
        return $this->Game_date_id;
    }

    public function setGameDateId(?\DateTimeInterface $Game_date_id): self
    {
        $this->Game_date_id = $Game_date_id;

        return $this;
    }





}
