<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isEasi;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $player;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $step;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $errorCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $helpCount;

    /**
     * @ORM\Column(type="integer")
     */
    private int $score;
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private int $errorStep;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private Serie $serie;

    /**
     * @ORM\OneToMany(targetEntity=HelpStat::class, mappedBy="game")
     */

    private Collection $helpStats;

    public function __construct()
    {
        $this->helpStats = new ArrayCollection();
    }

    public function getDateGame(): string
    {
        return $this->getCreatedAt()->format('d-m-Y à H:i');
    }

    public function getFirstWord(): Word
    {
        return $this->getSerie()->getWords()[0];
    }

    public function getObjectifPoint(): int
    {
        return count($this->getSerie()->getWords()) * 3;
    }

    public function getRateInProgress(): int
    {
        return $this->getScore() / $this->getObjectifPoint() * 100;
    }

    public function getWordCount(): int
    {
        return count($this->getSerie()->getWords());
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsEasi(): ?bool
    {
        return $this->isEasi;
    }

    public function setIsEasi(bool $isEasi): self
    {
        $this->isEasi = $isEasi;

        return $this;
    }

    public function getPlayer(): User
    {
        return $this->player;
    }

    public function setPlayer(User $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getErrorCount(): ?int
    {
        return $this->errorCount;
    }

    public function setErrorCount(?int $errorCount): self
    {
        $this->errorCount = $errorCount;

        return $this;
    }

    public function getHelpCount(): ?int
    {
        return $this->helpCount;
    }

    public function setHelpCount(?int $helpCount): self
    {
        $this->helpCount = $helpCount;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getErrorStep(): int
    {
        return $this->errorStep;
    }

    public function setErrorStep(int $errorStep): self
    {
        $this->errorStep = $errorStep;

        return $this;
    }

    public function getSerie(): Serie
    {
        return $this->serie;
    }

    public function setSerie(Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return Collection|HelpStat[]
     */
    public function getHelpStats(): Collection
    {
        return $this->helpStats;
    }

    public function addHelpStat(HelpStat $helpStat): self
    {
        if (!$this->helpStats->contains($helpStat)) {
            $this->helpStats[] = $helpStat;
            $helpStat->setGame($this);
        }

        return $this;
    }

    public function removeHelpStat(HelpStat $helpStat): self
    {
        if ($this->helpStats->removeElement($helpStat)) {
            // set the owning side to null (unless already changed)
            if ($helpStat->getGame() === $this) {
                $helpStat->setGame(null);
            }
        }

        return $this;
    }
}
