<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'e-mail indiqué est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message="L'email saisi n'est pas valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au moins 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mot de passe et sa confirmation ne se correspondent pas")
     */
    public $passwordConfirm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="validator")
     */
    private $validatedBookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="driver")
     */
    private $travelsConducted;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="customer")
     */
    private $bookings;

    public function __construct()
    {
        $this->validatedBookings = new ArrayCollection();
        $this->travelsConducted = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Booking[]
     */
    public function getValidatedBookings(): Collection
    {
        return $this->validatedBookings;
    }

    public function addValidatedBooking(Booking $validatedBooking): self
    {
        if (!$this->validatedBookings->contains($validatedBooking)) {
            $this->validatedBookings[] = $validatedBooking;
            $validatedBooking->setValidator($this);
        }

        return $this;
    }

    public function removeValidatedBooking(Booking $validatedBooking): self
    {
        if ($this->validatedBookings->contains($validatedBooking)) {
            $this->validatedBookings->removeElement($validatedBooking);
            // set the owning side to null (unless already changed)
            if ($validatedBooking->getValidator() === $this) {
                $validatedBooking->setValidator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getTravelsConducted(): Collection
    {
        return $this->travelsConducted;
    }

    public function addTravelsConducted(Booking $travelsConducted): self
    {
        if (!$this->travelsConducted->contains($travelsConducted)) {
            $this->travelsConducted[] = $travelsConducted;
            $travelsConducted->setDriver($this);
        }

        return $this;
    }

    public function removeTravelsConducted(Booking $travelsConducted): self
    {
        if ($this->travelsConducted->contains($travelsConducted)) {
            $this->travelsConducted->removeElement($travelsConducted);
            // set the owning side to null (unless already changed)
            if ($travelsConducted->getDriver() === $this) {
                $travelsConducted->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCustomer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }
}
