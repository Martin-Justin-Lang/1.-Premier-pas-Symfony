<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Program::class, inversedBy="Season")
     */
    private $program;

    /**
     * @ORM\OneToMany(targetEntity=Episode::class, mappedBy="season")
     */
    private $Episode;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->Episode = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramId(): ?int
    {
        return $this->program_id;
    }

    public function setProgramId(int $program_id): self
    {
        $this->program_id = $program_id;

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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->addProgramId($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->removeElement($program)) {
            $program->removeProgramId($this);
        }

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisode(): Collection
    {
        return $this->Episode;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->Episode->contains($episode)) {
            $this->Episode[] = $episode;
            $episode->setSeason($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->Episode->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getSeason() === $this) {
                $episode->setSeason(null);
            }
        }

        return $this;
    }
}