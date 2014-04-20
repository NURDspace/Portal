<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ClaimTransaction
 *
 * @ORM\Table(name="claim_transaction")
 * @ORM\Entity
 */
class ClaimTransaction
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
     * @ORM\Column(name="transaction_id", type="integer", nullable=false)
     */
    private $transactionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="claim_id", type="integer", nullable=false)
     */
    private $claimId;


}
