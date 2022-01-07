<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Serie
{
    public const NO_DEFINITION = 'À définir';

    public const GOOD_RATE = 90;

    public const MIDDLE_RATE = 50;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\OneToMany(targetEntity=Word::class, mappedBy="serie")
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
    private int $number;

    /**
     * @ORM\Column(type="integer")
     */
    private int $level;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="serie")
     */
    private Collection $games;

    /**
     * @ORM\ManyToOne(targetEntity=Letter::class, inversedBy="series")
     * @ORM\JoinColumn(nullable=false)
     */
    private Letter $letter;

    private int $noDefinitionCount = 0;

    private int $noEndPointCount = 0;

    public function __construct()
    {
        $this->words = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function setNoDefinitionCount(int $noDefinitionCount): void
    {
        $this->noDefinitionCount = $noDefinitionCount;
    }

    /**
     * @param int $noEndPoint
     */
    public function setNoEndPointCount(int $noEndPointCount): void
    {
        $this->noEndPointCount = $noEndPointCount;
    }

    public function getStats(): array
    {
        $result =  [];
        $result['no_definition'] = $this->noDefinitionCount;
        $result['no_endpoint']   = $this->noEndPointCount;
        $result['max']           = 0;
        $result['color']         = '';
        $result['rate']          = 0;
        $max = max($result);
        $result['max'] = $max;
        $wordsCount = count($this->getWords());
        $rate = ($wordsCount - $max) / $wordsCount * 100;
        if ($rate >= self::GOOD_RATE) {
            $result['color'] = 'success';
        } elseif ($rate >= self::MIDDLE_RATE) {
            $result['color'] = 'info';
        } elseif ($rate > 0) {
            $result['color'] = 'warning';
        }
        $result['rate'] = (int)$rate;

        return $result;
    }
    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $word->setSerie($this);
        }

        return $this;
    }

    public function removeWord(Word $word): self
    {
        if ($this->words->removeElement($word)) {
            // set the owning side to null (unless already changed)
            if ($word->getSerie() === $this) {
                $word->setSerie(null);
            }
        }

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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
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
            $game->setSerie($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->games->removeElement($game);

        return $this;
    }

    public function getLetter(): ?Letter
    {
        return $this->letter;
    }

    public function setLetter(?Letter $letter): self
    {
        $this->letter = $letter;

        return $this;
    }
}
