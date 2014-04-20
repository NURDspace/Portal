<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Claim
 *
 * @ORM\Table(name="claim")
 * @ORM\Entity
 */
class Claim
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Addressbook" , inversedBy="claims")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="addressbook_id", referencedColumnName="id")
     * })
     */
    private $addressbook;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="string", length=255, nullable=false)
     */
    private $descr;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amount;

    /** @ORM\ManyToMany(targetEntity="Transaction")
     *  @ORM\JoinTable(name="claim_transaction",
     *      joinColumns={@ORM\JoinColumn(name="claim_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="transaction_id", referencedColumnName="id")}
     *      )
     */
    private $transactions;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paid", type="boolean", nullable=false)
     */
    private $paid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paid_date", type="date", nullable=true)
     */
    private $paidDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepted", type="boolean", nullable=false)
     */
    private $accepted;

    public function getId() {
        return $this->id;
    }

    public function setAddressbook(Addressbook $address) {
        $this->addressbook = $address;
    }

    public function getAddressbook() {
        return $this->addressbook;
    }

    public function getDate() {
        return $this->date->format('Y-m-d');
    }

    public function setDate($date) {
        $this->date = new DateTime($date);
    }

    public function getDescr() {
        return $this->descr;
    }

    public function setDescr($descr) {
        $this->descr = $descr;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }
    public function getPaidDate() {
        return $this->paidDate->format('Y-m-d');
    }

    public function setPaidDate($paiddate) {
        $this->paidDate = new DateTime($paiddate);
    }

    public function getPaid() {
        return $this->paid;
    }

    public function setPaid($paid) {
        $this->paid = $paid;
    }

    public function getAccepted() {
        return $this->accepted;
    }
    
    public function setAccepted($accepted) {
        $this->accepted = $accepted;
    }
}
