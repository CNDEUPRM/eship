<?php
namespace Eship\EventBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Counselor
 *
 * @ORM\Table(name="counselor")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\CounselorRepository")
 */
class Counselor implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="counselorId", type="string", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $counselorId;
    /**
     * @var string
     * @ORM\Column(name="counselorEmail", type="string", length=255, unique=true)
     */
    private $counselorEmail;
    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;
    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;
    /**
     * @var string
     *
     * @ORM\Column(name="Initial", type="string", length=255)
     */
    private $initial;
    /**
     * @var string
     *
     * @ORM\Column(name="age", type="string", length=255)
     */
    private $age;
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=6)
     */
    private $gender;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;
    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=255)
     */
    private $department;
    /**
     * @var string
     *
     * @ORM\Column(name="cndeOrganization", type="string", length=255)
     */
    private $cndeOrganization;
    /**
     * @var string
     *
     * @ORM\Column(name="courses", type="text", nullable=true)
     */
    private $courses;
    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    /**
     * A non-persisted field that's used to create the encoded password.
     * @Assert\NotBlank(groups={"Registration"})
     *
     * @var string
     */
    private $plainPassword;
    /**
     * @var bool
     *
     * @ORM\Column(name="isAdmin", type="boolean")
     */
    private $isAdmin;

    /**
     * @ORM\Column(name="expertise", type="string")
     */
    private $expertise;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }
    /**
     * @return int
     */
    public function getCounselorId()
    {
        return $this->counselorId;
    }
    /**
     * Set counselorEmail
     *
     * @param string $counselorEmail
     * @return Counselor
     */
    public function setCounselorEmail($counselorEmail)
    {
        $this->counselorEmail = $counselorEmail;
        return $this;
    }
    /**
     * Get counselorEmail
     *
     * @return string
     */
    public function getCounselorEmail()
    {
        return $this->counselorEmail;
    }
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Counselor
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
     * @return Counselor
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
     * Set initial
     *
     * @param string $initial
     * @return Counselor
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;
        return $this;
    }
    /**
     * Get initial
     *
     * @return string
     */
    public function getInitial()
    {
        return $this->initial;
    }
    /**
     * Set age
     *
     * @param string $age
     * @return Counselor
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }
    /**
     * Get age
     *
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }
    /**
     * Set gender
     *
     * @param string $gender
     * @return Counselor
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }
    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }
    /**
     * Set phone
     *
     * @param string $phone
     * @return Counselor
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set position
     *
     * @param string $position
     * @return Counselor
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Set department
     *
     * @param string $department
     * @return Counselor
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }
    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }
    /**
     * Set cndeOrganization
     *
     * @param string $cndeOrganization
     * @return Counselor
     */
    public function setCndeOrganization($cndeOrganization)
    {
        $this->cndeOrganization = $cndeOrganization;
        return $this;
    }
    /**
     * Get cndeOrganization
     *
     * @return string
     */
    public function getCndeOrganization()
    {
        return $this->cndeOrganization;
    }
    /**
     * @return string
     */
    public function getCourses()
    {
        return $this->courses;
    }
    /**
     * @param string $courses
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;
    }
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Counselor
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
    public function getRoles()
    {
        if($this->getIsAdmin()==1)
        {
            return ['ROLE_ADMIN'];
        }
        return ['ROLE_COUNSELOR'];
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getSalt()
    {
        return null;
    }
    public function getUsername()
    {
        return $this->counselorEmail;
    }
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        // guarantees that the entity looks "dirty" to Doctrine
        // when changing the plainPassword
        $this->password = null;
    }

    /**
     * @return mixed
     */
    public function getExpertise()
    {
        return $this->expertise;
    }

    /**
     * @param mixed $expertise
     */
    public function setExpertise($expertise)
    {
        $this->expertise = $expertise;
    }
}