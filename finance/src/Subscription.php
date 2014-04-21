<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription", indexes={@ORM\Index(name="Addressbook", columns={"addressbook_id"})})
 * @ORM\Entity
 */
class Subscription
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function getId() {
        return $this->id;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    public function getStartDate() {
        return $this->startDate->format('Y-m-d');
    }

    public function setStartDate($date) {
        $this->startDate = new DateTime($date);
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    public function getEndDate() {
        return $this->endDate->format('Y-m-d');
    }

    public function setEndDate($date) {
        $this->endDate = new DateTime($date);
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_invoice_date", type="date", nullable=true)
     */
    private $lastInvoiceDate;

    public function getLastInvoiceDate() {
        if ($this->lastInvoiceDate != null)
            return $this->lastInvoiceDate->format('Y-m-d');
        else
            return "0000-00-00";
    }

    public function setLastInvoiceDate($date) {
        $this->lastInvoiceDate = new DateTime($date);
    }

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amount;

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="string", length=255, nullable=false)
     */
    private $descr;

    public function getDescr() {
        return $this->descr;
    }

    public function setDescr($descr) {
        $this->descr = $descr;
    }

    /**
     * @var \Addressbook
     *
     * @ORM\ManyToOne(targetEntity="Addressbook")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="addressbook_id", referencedColumnName="id")
     * })
     */
    private $addressbook;

    public function setAddressbook(Addressbook $address) {
        $this->addressbook = $address;
    }

    public function getAddressbook() {
        return $this->addressbook;
    }
}
