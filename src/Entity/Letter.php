<?php

namespace App\Entity;

use App\Repository\LetterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LetterRepository::class)
 */
class Letter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity=Word::class, inversedBy="letters")
     */
    private $word;

    public function __construct()
    {
        $this->word = new ArrayCollection();
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

    /**
     * @return Collection|Word[]
     */
    public function getWord(): Collection
    {
        return $this->word;
    }

    public function addWord(Word $word): self
    {
        if (!$this->word->contains($word)) {
            $this->word[] = $word;
        }

        return $this;
    }

    public function removeWord(Word $word): self
    {
        $this->word->removeElement($word);

        return $this;
    }
}
