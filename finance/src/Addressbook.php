<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Addressbook
 *
 * @ORM\Table(name="addressbook", uniqueConstraints={@ORM\UniqueConstraint(name="nick", columns={"nick"})})
 * @ORM\Entity
 */
class Addressbook
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nick", type="string", length=255, nullable=false)
     */
    private $nick;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10, nullable=false)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;


    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="addressbook")
     */
    private $invoices;

    public function getInvoices() {
        return $this->invoices;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getNick() {
        return $this->nick;
    }

    public function setNick($nick)
    {
        $this->nick = $nick;
    }
}
