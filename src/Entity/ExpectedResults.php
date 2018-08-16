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
     *      minMessage = "The number must be greater than or equal to {{ limit }}",
     *      maxMessage = "The number must be less than  {{ limit }}"
     * )
     */
    private $FirstTeamScoreExpected;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *  @Assert\Range(
     *      min = 0,
     *      max = 50,
     *      minMessage = "The number must be greater than or equal to {{ limit }}",
     *      maxMessage = "The number must be less than  {{ limit }}"
     * )
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="expectedResultsID")
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

    public function getUserId(): User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): void
    {
        $this->user_id = $user_id;

    }
}
