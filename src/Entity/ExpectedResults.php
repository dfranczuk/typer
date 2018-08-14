<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $FirstTeamScoreExpected;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $SecondTeamScoreExpected;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game")
     */
    private $NameOfMeeting;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Game")
     */
    private $game_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

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

    public function getgame_date(): ?Game
    {
        return $this->game_date;
    }

    public function setgame_date(?Game $game_date): self
    {
        $this->game_date = $game_date;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

}
