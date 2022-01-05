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
    private ?User $player;

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
     * @ORM\ManyToMany(targetEntity=Letter::class)
     */
    private Collection $letters;

    /**
     * @ORM\ManyToMany(targetEntity=Word::class)
     */
    private Collection $words;

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

    public function getObjectifPoint(): int
    {
        return count($this->getWords()) * 3;
    }

    public function getRateInProgress(): int
    {
        return $this->getScore() / $this->getObjectifPoint() * 100;
    }

    public function getWordCount(): int
    {
        return count($this->getWords());
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

    public function __construct()
    {
        $this->letters = new ArrayCollection();
        $this->words = new ArrayCollection();
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

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
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

    /**
     * @return Collection|Letter[]
     */
    public function getletters(): Collection
    {
        return $this->letters;
    }

    public function addletters(Letter $letters): self
    {
        if (!$this->letters->contains($letters)) {
            $this->letters[] = $letters;
        }

        return $this;
    }

    public function removeletters(Letter $letters): self
    {
        $this->letters->removeElement($letters);

        return $this;
    }

    /**
     * @return Collection|Word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function addWord(Word $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
        }

        return $this;
    }

    public function removeWord(Word $word): self
    {
        $this->words->removeElement($word);

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

    public function addLetter(Letter $letter): self
    {
        if (!$this->letters->contains($letter)) {
            $this->letters[] = $letter;
        }

        return $this;
    }

    public function removeLetter(Letter $letter): self
    {
        $this->letters->removeElement($letter);

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
}
