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
}
