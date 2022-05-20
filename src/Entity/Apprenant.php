<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Table;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApprenantRepository::class)]
#[Table(name: 'Apprenants')]
class Apprenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $prenom;
    
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private $age;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: Formation::class, inversedBy: 'apprenants')]
    #[ORM\JoinColumn(nullable: false)]
    private $formation;

    #[ORM\OneToMany(mappedBy: 'apprenant', targetEntity: Retard::class, orphanRemoval: true)]
    private $retards;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->retards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Retard>
     */
    public function getRetards(): Collection
    {
        return $this->retards;
    }

    public function addRetard(Retard $retard): self
    {
        if (!$this->retards->contains($retard)) {
            $this->retards[] = $retard;
            $retard->setApprenant($this);
        }

        return $this;
    }

    public function removeRetard(Retard $retard): self
    {
        if ($this->retards->removeElement($retard)) {
            // set the owning side to null (unless already changed)
            if ($retard->getApprenant() === $this) {
                $retard->setApprenant(null);
            }
        }

        return $this;
    }

}
