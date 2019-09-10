<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StepRepository")
 */
class Step
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", )
     */
    private $numberStep;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="steps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $steps;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberStep(): ?int
    {
        return $this->numberStep;
    }

    public function setNumberStep(int $numberStep): self
    {
        $this->numberStep = $numberStep;

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

    public function getSteps(): ?Recipe
    {
        return $this->steps;
    }

    public function setSteps(?Recipe $steps): self
    {
        $this->steps = $steps;

        return $this;
    }
}
