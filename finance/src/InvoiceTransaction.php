<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceTransaction
 *
 * @ORM\Table(name="invoice_transaction", indexes={@ORM\Index(name="invoice_id", columns={"invoice_id"}), @ORM\Index(name="transaction_id", columns={"transaction_id"})})
 * @ORM\Entity
 */
class InvoiceTransaction
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
     * @var \Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     * })
     */
    private $transaction;

    /**
     * @var \Invoice
     *
     * @ORM\ManyToOne(targetEntity="Invoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * })
     */
    private $invoice;


}
