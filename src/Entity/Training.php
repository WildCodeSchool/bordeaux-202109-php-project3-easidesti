<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Training
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Word::class)
     */
    private Collection $words;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $player;

    /**
     * @ORM\Column(type="integer")
     */
    private int $step;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $errorCount;

    /**
     * @ORM\Column(type="integer")
     */
    private int $score;

    /**
     * @ORM\OneToMany(targetEntity=HistoryTraining::class, mappedBy="training", orphanRemoval=true)
     */
    private Collection $historyTrainings;

    public function __construct()
    {
        $this->words = new ArrayCollection();
        $this->historyTrainings = new ArrayCollection();
    }

    public function countLetterErrors(): array
    {
        $errors = [];
        foreach ($this->getHistoryTrainings() as $historyTraining) {
            $errors[] = $historyTraining->getLetter();
        }
        return array_count_values($errors);
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getRateInProgress(): int
    {
        return $this->getScore() / count($this->getWords()) * 100;
    }

    public function getWordCount(): int
    {
        return count($this->getWords());
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|HistoryTraining[]
     */
    public function getHistoryTrainings(): Collection
    {
        return $this->historyTrainings;
    }

    public function addHistoryTraining(HistoryTraining $historyTraining): self
    {
        if (!$this->historyTrainings->contains($historyTraining)) {
            $this->historyTrainings[] = $historyTraining;
            $historyTraining->setTraining($this);
        }

        return $this;
    }

    public function removeHistoryTraining(HistoryTraining $historyTraining): self
    {
        if ($this->historyTrainings->removeElement($historyTraining)) {
            // set the owning side to null (unless already changed)
            if ($historyTraining->getTraining() === $this) {
                $historyTraining->setTraining(null);
            }
        }

        return $this;
    }
}
