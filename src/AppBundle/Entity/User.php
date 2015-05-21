<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use AppBundle\Entity\Role;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, \Serializable
{

    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(name="firstName", type="string", length=30, nullable=true)
     *
     * @Assert\NotBlank()
     *
     */
    protected $firstName;

    /**
     *
     * @ORM\Column(name="lastName", type="string", length=30, nullable=true)
     *
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=true)
     *
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=4)
     *
     * @var string username
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=4)
     *
     * @var string password
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @var string salt
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection $userRoles
     */
    protected $userRoles;

    /**
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    protected $createdAt;


    /**
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     *
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Share", mappedBy="user")
     */
    private $userShare;


    /**
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param string $value The username.
     */
    public function setUsername($value)
    {
        $this->username = $value;
    }

    /**
     *
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @param string $value The password.
     */
    public function setPassword($value)
    {
        $this->password = $value;
    }

    /**
     *
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     *
     * @param string $value The salt.
     */
    public function setSalt($value)
    {
        $this->salt = $value;
    }

    /**
     *
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Конструктор класса User
     */
    public function __construct()
    {
        $this->userRoles = new ArrayCollection();

        $this->idShare = new ArrayCollection();
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setSalt(md5(time()));

        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($this->getPassword(), $this->getSalt());
        $this->setPassword($password);

        $this->createdAt = new \DateTime();
    }

    /**
     * Gets triggered only on insert
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Сброс прав пользователя.
     */
    public function eraseCredentials()
    {

    }

    /**
     *
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

    /**
     * Сравнивает пользователя с другим пользователем и определяет
     * один и тот же ли это человек.
     *
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function isEqualTo(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add userRoles
     *
     * @param \AppBundle\Entity\Role $userRoles
     * @return User
     */
    public function addUserRole(\AppBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;

        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param \AppBundle\Entity\Role $userRoles
     */
    public function removeUserRole(\AppBundle\Entity\Role $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }


    /**
     * Add userShare
     *
     * @param \AppBundle\Entity\Share $userShare
     * @return User
     */
    public function addUserShare(Share $idShare)
    {
        $this->userShare[] = $idShare;

        return $this;
    }

    /**
     * Remove userShare
     *
     * @param \AppBundle\Entity\Share $userShare
     */
    public function removeUserShare(Share $idShare)
    {
        $this->userShare->removeElement($idShare);
    }

    /**
     * Get userShare
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserShare()
    {
        return $this->userShare;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->salt,
            $this->createdAt,
            serialize($this->userRoles),
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->firstName, $this->lastName,
            $this->salt, $this->createdAt) = unserialize(
            $serialized);
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}
