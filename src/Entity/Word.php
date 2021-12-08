<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WordRepository::class)
 */
class Word
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="text")
     */
    private $definition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $audio;

    /**
     * @ORM\ManyToMany(targetEntity=Letter::class, mappedBy="word")
     */
    private $letters;


    /**
     * @ORM\ManyToOne(targetEntity=EndPoint::class, inversedBy="word")
     * @ORM\JoinColumn(nullable=false)
     */
    private $endPoint;

    /**
     * @ORM\OneToMany(targetEntity=EndPoint::class, mappedBy="word")
     */
    private $endPoints;

    /**
     * @ORM\OneToMany(targetEntity=MuteLetter::class, mappedBy="word", orphanRemoval=true)
     */
    private $muteLetters;

    public function __construct()
    {
        $this->letters = new ArrayCollection();
        $this->endPoints = new ArrayCollection();
        $this->muteLetters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(string $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * @return Collection|Letter[]
     */
    public function getLetters(): Collection
    {
        return $this->letters;
    }

    public function addLetter(Letter $letter): self
    {
        if (!$this->letters->contains($letter)) {
            $this->letters[] = $letter;
            $letter->addWord($this);
        }

        return $this;
    }

    public function removeLetter(Letter $letter): self
    {
        if ($this->letters->removeElement($letter)) {
            $letter->removeWord($this);
        }

        return $this;
    }

    public function getEndPoint(): ?EndPoint
    {
        return $this->endPoint;
    }

    public function setEndPoint(?EndPoint $endPoint): self
    {
        $this->endPoint = $endPoint;

        return $this;
    }

    /**
     * @return Collection|EndPoint[]
     */
    public function getEndPoints(): Collection
    {
        return $this->endPoints;
    }

    public function addEndPoint(EndPoint $endPoint): self
    {
        if (!$this->endPoints->contains($endPoint)) {
            $this->endPoints[] = $endPoint;
            $endPoint->setWord($this);
        }

        return $this;
    }

    public function removeEndPoint(EndPoint $endPoint): self
    {
        if ($this->endPoints->removeElement($endPoint)) {
            // set the owning side to null (unless already changed)
            if ($endPoint->getWord() === $this) {
                $endPoint->setWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MuteLetter[]
     */
    public function getMuteLetters(): Collection
    {
        return $this->muteLetters;
    }

    public function addMuteLetter(MuteLetter $muteLetter): self
    {
        if (!$this->muteLetters->contains($muteLetter)) {
            $this->muteLetters[] = $muteLetter;
            $muteLetter->setWord($this);
        }

        return $this;
    }

    public function removeMuteLetter(MuteLetter $muteLetter): self
    {
        if ($this->muteLetters->removeElement($muteLetter)) {
            // set the owning side to null (unless already changed)
            if ($muteLetter->getWord() === $this) {
                $muteLetter->setWord(null);
            }
        }

        return $this;
    }
}
