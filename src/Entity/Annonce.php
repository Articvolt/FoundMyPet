<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 25)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProprietaire = null;

    #[ORM\Column(length: 200)]
    private ?string $prenomProprietaire = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 200)]
    private ?string $nomAnimal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseMail = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100)]
    private ?string $category = null;

    #[ORM\Column(length: 50)]
    private ?string $espece = null;

    #[ORM\Column]
    private ?int $ageAnimal = null;

    #[ORM\Column(length: 150)]
    private ?string $sexeAnimal = null;

    #[ORM\Column(length: 100)]
    private ?string $puce = null;

    #[ORM\Column(length: 100)]
    private ?string $tatoue = null;

    #[ORM\Column(length: 100)]
    private ?string $taillePoil = null;

    #[ORM\Column(length: 100)]
    private ?string $dessinPoil = null;

    #[ORM\Column(type: Types::JSON)]
    private array $couleurPoil = [];

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Image::class,
    orphanRemoval: true,
    cascade: ["persist"] )]
    private Collection $images;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->images = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNomProprietaire(): ?string
    {
        return $this->nomProprietaire;
    }

    public function setNomProprietaire(string $nomProprietaire): self
    {
        $this->nomProprietaire = $nomProprietaire;

        return $this;
    }

    public function getPrenomProprietaire(): ?string
    {
        return $this->prenomProprietaire;
    }

    public function setPrenomProprietaire(string $prenomProprietaire): self
    {
        $this->prenomProprietaire = $prenomProprietaire;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNomAnimal(): ?string
    {
        return $this->nomAnimal;
    }

    public function setNomAnimal(string $nomAnimal): self
    {
        $this->nomAnimal = $nomAnimal;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(?string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    public function getAgeAnimal(): ?int
    {
        return $this->ageAnimal;
    }

    public function setAgeAnimal(int $ageAnimal): self
    {
        $this->ageAnimal = $ageAnimal;

        return $this;
    }

    public function getSexeAnimal(): ?string
    {
        return $this->sexeAnimal;
    }

    public function setSexeAnimal(string $sexeAnimal): self
    {
        $this->sexeAnimal = $sexeAnimal;

        return $this;
    }

    public function getPuce(): ?string
    {
        return $this->puce;
    }

    public function setPuce(string $puce): self
    {
        $this->puce = $puce;

        return $this;
    }

    public function getTatoue(): ?string
    {
        return $this->tatoue;
    }

    public function setTatoue(string $tatoue): self
    {
        $this->tatoue = $tatoue;

        return $this;
    }

    public function getTaillePoil(): ?string
    {
        return $this->taillePoil;
    }

    public function setTaillePoil(string $taillePoil): self
    {
        $this->taillePoil = $taillePoil;

        return $this;
    }

    public function getDessinPoil(): ?string
    {
        return $this->dessinPoil;
    }

    public function setDessinPoil(string $dessinPoil): self
    {
        $this->dessinPoil = $dessinPoil;

        return $this;
    }

    public function getCouleurPoil(): array
    {
        return $this->couleurPoil;
    }

    public function setCouleurPoil(array $couleurPoil): self
    {
        $this->couleurPoil = $couleurPoil;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAnnonce($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAnnonce() === $this) {
                $message->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nomAnimal;
    }


}
