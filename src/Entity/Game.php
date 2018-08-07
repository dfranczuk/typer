<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournament")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournamient;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $first_team;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $second_team;

    /**
     * @ORM\Column(type="integer")
     */
    private $first_team_score;

    /**
     * @ORM\Column(type="integer")
     */
    private $second_team_score;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $game_date;



    public function getId()
    {
        return $this->id;
    }

    public function getTournamient(): ?int
    {
        return $this->tournamient;
    }

    public function setTournamient(Tournament $tournamient): self
    {
        $this->tournamient = $tournamient;

        return $this;
    }

    public function getFirstTeam(): ?int
    {
        return $this->first_team;
    }

    public function setFirstTeam(Team $first_team): self
    {
        $this->first_team = $first_team;

        return $this;
    }

    public function getSecondTeam(): ?int
    {
        return $this->second_team;
    }

    public function setSecondTeam(Team $second_team): self
    {
        $this->second_team = $second_team;

        return $this;
    }

    public function getFirstTeamScore(): ?int
    {
        return $this->first_team_score;
    }

    public function setFirstTeamScore(int $first_team_score): self
    {
        $this->first_team_score = $first_team_score;

        return $this;
    }

    public function getSecondTeamScore(): ?int
    {
        return $this->second_team_score;
    }

    public function setSecondTeamScore(int $second_team_score): self
    {
        $this->second_team_score = $second_team_score;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->game_date;
    }

    public function setGameDate(\DateTimeInterface $game_date): self
    {
        $this->game_date = $game_date;

        return $this;
    }
}
