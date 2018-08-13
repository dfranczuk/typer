<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $first_team_score;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $second_team_score;

    /**
     * @ORM\Column(type="datetime")
     */
    private $game_date;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournament", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeofWeight", inversedBy="Game")
     */
    private $TypeofWeight;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getTypeofWeight()
    {
        return $this->TypeofWeight;
    }
    /**
     * @param mixed $TypeofWeight
     */
    public function setTypeofWeight($TypeofWeight): void
    {
        $this->TypeofWeight = $TypeofWeight;
    }

    public $flaga=true;
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return bool
     */
    public function isFlaga(): bool
    {
        return $this->flaga;
    }
    /**
     * @param bool $flaga
     */
    public function setFlaga(bool $flaga): void
    {
        $this->flaga = $flaga;
    }
    /**
     * @return mixed
     */
    public function getFirstTeam()
    {
        return $this->first_team;
    }
    public function setFirstTeam(Team $first_team): self
    {
        $this->first_team = $first_team;
        return $this;
    }
    public function getSecondTeam()
    {
        return $this->second_team;
    }
    public function setSecondTeam(Team $second_team): self
    {
        if($this->getFirstTeam()!=$second_team){
            $flaga=true;
        }else{
            $flaga=false;
        }
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
    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->game_date;
    }
    public function setGameDate(\DateTimeInterface $game_date): self
    {
        $this->game_date = $game_date;
        return $this;
    }
    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }
    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;
        return $this;
    }


}