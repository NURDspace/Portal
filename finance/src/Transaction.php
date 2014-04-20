<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", uniqueConstraints={@ORM\UniqueConstraint(name="seq", columns={"seq", "date", "cdtdbt", "accountnr", "name", "descr", "amount"})})
 * @ORM\Entity
 */
class Transaction
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
     * @var integer
     *
     * @ORM\Column(name="seq", type="integer", nullable=false)
     */
    private $seq;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="cdtdbt", type="string", length=10, nullable=false)
     */
    private $cdtdbt;

    /**
     * @var string
     *
     * @ORM\Column(name="accountnr", type="string", length=50, nullable=false)
     */
    private $accountnr;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

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

    /** @ORM\ManyToMany(targetEntity="Invoice") 
     *  @ORM\JoinTable(name="invoice_transaction",
     *      joinColumns={@ORM\JoinColumn(name="transaction_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="invoice_id", referencedColumnName="id")}
     *      )
    */
    private $invoices;

    /** @ORM\ManyToMany(targetEntity="Claim")
     *  @ORM\JoinTable(name="claim_transaction",
     *      joinColumns={@ORM\JoinColumn(name="transaction_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="claim_id", referencedColumnName="id")}
     *      )
     */
    private $claims;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->claims = new ArrayCollection();
    }

    public function getInvoices()
    {
        return $this->invoices;
    }

    public function getClaims()
    {
        return $this->claims;
    }

    public function getId() {
        return $this->id;
    }

    public function getSeq() {
        return $this->seq;
    }

    public function setSeq($seq) {
        $this->seq = $seq;
    }

    public function getDate() {
        return $this->date->format('Y-m-d');
    }

    public function setDate($date) {
        $this->date = new DateTime($date);
    }

    public function getCdtDbt() {
        return $this->cdtdbt;
    }

    public function setCdtDbt($cdtdbt) {
        $this->cdtdbt = $cdtdbt;
    }

    public function getAccountNr() {
        return $this->accountnr;
    }

    public function setAccountNr($accountnr) {
        $this->accountnr = $accountnr;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
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


}
