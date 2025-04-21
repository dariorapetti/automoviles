<?php

namespace App\Entity;

use App\Entity\Traits\Habilitado;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Usuario implements UserInterface {

    use Habilitado;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=20, nullable=true, unique=true)
     */
    private $cuit;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Grupo", inversedBy="usuarios")
     * @ORM\JoinTable(name="usuario_grupo")
     * @Assert\NotNull()
     * @Assert\Count(min=1, minMessage="Debe tener al menos {{ limit }} grupo asignado")
     */
    protected $grupos;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=255, nullable=true)
     */
    protected $confirmationToken;

    /**
     * @var \Datetime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastSeen;

    /**
     * @ORM\Column(name="allow_password_change", type="boolean", nullable=true, options={"default": 0})
     */
    private $allowPasswordChange;

    /**
     * @var integer
     * @ORM\Column(name="login_attempts", type="integer", nullable=true, options={"default": 0})
     */
    protected $loginAttempts;

    public function __toString(): string {
        return ($this->email != null) ? $this->email : $this->getNombre() . ' ' . $this->getApellido();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = [];

        foreach ($this->getGrupos() as $grupo) {
            $roles = array_merge($roles, $grupo->getRoles());
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string {
        return (string) $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGrupos() {
        return $this->grupos ?: $this->grupos = new ArrayCollection();
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return Usuario
     */
    public function setConfirmationToken($confirmationToken): Usuario {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken(): ?string {
        return $this->confirmationToken;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->habilitado = 1;
        $this->loginAttempts = 0;
        $this->allowPasswordChange = true;
    }

    /**
     * Add grupo
     *
     * @param Grupo $grupo
     * @return Usuario
     */
    public function addGrupo(Grupo $grupo) {
        $this->grupos[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param Grupo $grupo
     */
    public function removeGrupo(Grupo $grupo) {
        $this->grupos->removeElement($grupo);
    }

    /**
     * @return \Datetime
     */
    public function getLastSeen() {
        return $this->lastSeen;
    }

    /**
     * 
     * @param type $lastSeen
     * @return self
     */
    public function setLastSeen($lastSeen): self {
        $this->lastSeen = $lastSeen;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isActiveNow(): bool {
        $delay = new \DateTime('2 minutes ago');

        return ( $this->getLastSeen() > $delay );
    }

    /**
     * Get the value of cuit
     */
    public function getCuit() {
        return $this->cuit;
    }

    /**
     * Set the value of cuit
     *
     * @return  self
     */
    public function setCuit($cuit) {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getNombreCompleto() {
        return $this->nombre . ' ' . $this->apellido;
    }

    /**
     * Get the value of loginAttempts
     */
    public function getLoginAttempts() {
        return $this->loginAttempts;
    }

    /**
     * Set the value of loginAttempts
     *
     * @return  self
     */
    public function setLoginAttempts($loginAttempts) {
        $this->loginAttempts = $loginAttempts;

        return $this;
    }

    /**
     * Get allowPasswordChange
     *
     * @return boolean
     */
    public function getAllowPasswordChange()
    {
        return $this->allowPasswordChange;
    }

    /**
     * Set allowPasswordChange
     *
     * @param boolean
     *
     * @return Usuario
     */
    public function setAllowPasswordChange($allowPasswordChange)
    {
        $this->allowPasswordChange = $allowPasswordChange;

        return $this;
    }
}
