<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectsRepository::class)
 */
class Projects
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price_sold;

    /**
     * @ORM\Column(type="integer")
     */
    private $estimated_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $spent_time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $technology;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="projects")
     */
    private $companies;

    /**
     * @ORM\ManyToMany(targetEntity=Workers::class, inversedBy="projects")
     */
    private $workers;

    public function __construct()
    {
        $this->workers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
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

    public function getPriceSold(): ?float
    {
        return $this->price_sold;
    }

    public function setPriceSold(float $price_sold): self
    {
        $this->price_sold = $price_sold;

        return $this;
    }

    public function getEstimatedTime(): ?int
    {
        return $this->estimated_time;
    }

    public function setEstimatedTime(int $estimated_time): self
    {
        $this->estimated_time = $estimated_time;

        return $this;
    }

    public function getSpentTime(): ?int
    {
        return $this->spent_time;
    }

    public function setSpentTime(int $spent_time): self
    {
        $this->spent_time = $spent_time;

        return $this;
    }

    public function getTechnology(): ?string
    {
        return $this->technology;
    }

    public function setTechnology(string $technology): self
    {
        $this->technology = $technology;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCompanies(): ?Companies
    {
        return $this->companies;
    }

    public function setCompanies(?Companies $companies): self
    {
        $this->companies = $companies;

        return $this;
    }

    /**
     * @return Collection|Workers[]
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    public function addWorker(Workers $worker): self
    {
        if (!$this->workers->contains($worker)) {
            $this->workers[] = $worker;
        }

        return $this;
    }

    public function removeWorker(Workers $worker): self
    {
        $this->workers->removeElement($worker);

        return $this;
    }
}
