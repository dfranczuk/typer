<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TournamentRepository")
 * @UniqueEntity(fields="name", message="Tournament already exist")
 */
class Tournament
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOfEvent", inversedBy="Tournament")
     */
    private $TypeOfEvent;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="tournament")
     */
    private $games;
    public function __construct()
    {
        $this->games = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getTypeOfEvent()
    {
        return $this->TypeOfEvent;
    }
    /**
     * @param mixed $TypeOfEvent
     */
    public function setTypeOfEvent($TypeOfEvent): void
    {
        $this->TypeOfEvent = $TypeOfEvent;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }
    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }
    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setTournament($this);
        }
        return $this;
    }
    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getTournament() === $this) {
                $game->setTournament(null);
            }
        }
        return $this;
    }
}