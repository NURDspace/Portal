<?
require("bootstrap.php");

function get_addressbook_by_nick($nick) {
    global $entityManager;
    $addressbook = $entityManager->getRepository('Addressbook')->findOneBy(array('nick' => $nick));
    if (!$addressbook) {
        return null; 
    } else
        return $addressbook->getId();
}

function get_user_dept($addressbook_id) {
    global $entityManager;
    $invoices = $entityManager->getRepository('Invoice')->findBy(array('paid'=>0,'addressbook'=>$addressbook_id));
    $amount = 0.00;
    foreach ($invoices as $invoice) { 
        $amount = $amount + $invoice->getAmount(); 
    }
    return $amount;
}

function select_openinvoices() {
    global $entityManager;
    $output = "";
    $invoices = $entityManager->getRepository('Invoice')->findBy(array('paid'=>0));
    foreach ($invoices as $invoice) {
        $output = $output . "<option value=\"{$invoice->getId()}\">{$invoice->getDate()} {$invoice->getAddressbook()->getNick()} ({$invoice->getAddressbook()->getName()}) - {$invoice->getDescr()} ({$invoice->getAmount()})</option>";
    }
    return $output;
}

function select_openclaims() {
    global $entityManager;
    $output = "";
    $claims = $entityManager->getRepository('Claim')->findBy(array('paid'=>0,'accepted'=>1));
    foreach ($claims as $claim) {
        $output = $output . "<option value=\"{$claim->getId()}\">{$claim->getDate()} {$claim->getAddressbook()->getNick()} ({$claim->getAddressbook()->getName()}) - {$claim->getDescr()} ({$claim->getAmount()})</option>";
    }
    return $output;
}

function get_addressbook(){
    global $entityManager;
    $output = array();
    $addressbooks = $entityManager->getRepository('Addressbook')->findAll();
    foreach($addressbooks as $address) { 
        $output[$address->getId()] = "{$address->getName()} - {$address->getNick()}";
    }
    return $output;
}

function select_addressbook(){
    $addressbook = get_addressbook();
    $output = "";
    foreach ($addressbook as $key => $value) {
        $output = $output . "<option value=\"{$key}\">$value</option>";
    }
    return $output;
}

function transaction_amount($transaction_id) {
    global $entityManager;
    return $entityManager->getRepository('Transaction')->findOneBy(array('id'=>$transaction_id))->getAmount();
}

function invoice_amount($invoice_id) {
    global $entityManager;
    return $entityManager->getRepository('Invoice')->findOneBy(array('id'=>$invoice_id))->getAmount();
}



function transaction_crdt_booked($transaction_id) {
    global $entityManager;
    $transaction = $entityManager->getRepository('Transaction')->findOneBy(array('id'=>$transaction_id));
    $transaction_amount = $transaction->getAmount(); 
    $invoice_amount = 0.00;
    $invoices = $transaction->getInvoices();
    foreach ($invoices as $invoice) {
        $invoice_amount = $invoice_amount + $invoice->getAmount();
    }
    if (($transaction->getAmount() - $invoice_amount) == 0)
        return true;
    else
        return false;
}

function transaction_dbit_booked($transaction_id) {
    global $entityManager;
    $transaction = $entityManager->getRepository('Transaction')->findOneBy(array('id'=>$transaction_id));
    $transaction_amount = $transaction->getAmount(); 
    $claim_amount = 0.00;
    $claims = $transaction->getClaims();
    foreach ($claims as $claim) {
        $claim_amount = $claim_amount + $claim->getAmount();
    }
    if (($transaction->getAmount() - $claim_amount) == 0)
        return true;
    else
        return false;
}

?>
