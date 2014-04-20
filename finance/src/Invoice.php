<?php
use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice", indexes={@ORM\Index(name="subscription_id", columns={"subscription_id"}), @ORM\Index(name="addressbook_id", columns={"addressbook_id"})})
 * @ORM\Entity
 */
class Invoice
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
     * @var \Subscription
     *
     * @ORM\ManyToOne(targetEntity="Subscription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     * })
     */
    private $subscription;

    /**
     * @var \Addressbook
     *
     * @ORM\ManyToOne(targetEntity="Addressbook" , inversedBy="Invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="addressbook_id", referencedColumnName="id")
     * })
     */
    private $addressbook;

    /** @ORM\ManyToMany(targetEntity="Transaction") 
     *  @ORM\JoinTable(name="invoice_transaction",
     *      joinColumns={@ORM\JoinColumn(name="invoice_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="transaction_id", referencedColumnName="id")}
     *      )
    */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function setAddressbook(Addressbook $address) {
        $this->addressbook = $address;
    }

    public function getAddressbook() {
        return $this->addressbook;
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

    public function getAmount() {
        return $this->amount;
    }
    
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getDescr() {
        return $this->descr;
    }

    public function setDescr($descr) {
        $this->descr = $descr;
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date->format('Y-m-d');
    }

    public function setDate($date) {
        $this->date = new DateTime($date);
    }

    public function setSubscription(Subscription $subscription) {
        $this->subscription = $subscription;
    }
}
