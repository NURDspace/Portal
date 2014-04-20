<?
include("../functions.php");
require("bootstrap.php");
if (!has_role("finance")) {
echo "Access Denied";
exit();
}

if (isset($_FILES['userfile']['name'])) {
    $uploaddir = '/tmp/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $import = simplexml_load_file($uploadfile);
    }
}
?>
<html>
<head>
<title>Nurdspace user system</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
<link rel="stylesheet" type="text/css" href="../table-style.css" />
</head>
<body>
<div id="top">

<div id="header">
<H1>All hail <?=$_SERVER['Shib-givenName']?></H1>
</div>
<?include("menu.php");?>
<div class="clear"> </div>

</div>

<div id="contentwrap">

<div class="cright">
<h2>Bank import</h2>
<form enctype="multipart/form-data" method="POST">
<input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<?
if (isset($_FILES['userfile']['name'])) {
?>
<table id="hor-minimalist-b">
<?
foreach ($import->BkToCstmrStmt->Stmt as $stmt) {
    $seq = $stmt->LglSeqNb;
    echo "<tr><th>".$stmt->LglSeqNb."</th></tr>";
    foreach ($stmt->Ntry as $Ntry) {
        //print_r($Ntry);
        $amount = $Ntry->Amt;
        $CdtDbt = $Ntry->CdtDbtInd;
        $date = $Ntry->BookgDt->Dt;
        if ($Ntry->CdtDbtInd == "CRDT") {
            $name = $Ntry->NtryDtls->TxDtls->RltdPties->Dbtr->Nm;
            $account = (isset($Ntry->NtryDtls->TxDtls->RltdPties->DbtrAcct->Id->IBAN))?$Ntry->NtryDtls->TxDtls->RltdPties->DbtrAcct->Id->IBAN:$Ntry->NtryDtls->TxDtls->RltdPties->DbtrAcct->Id->Othr->Id;
        }else{
            $name = $Ntry->NtryDtls->TxDtls->RltdPties->Cdtr->Nm;
            if (isset($Ntry->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->Othr->Id)) {
                $account = (isset($Ntry->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->IBAN))?$Ntry->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->IBAN:$Ntry->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->Othr->Id;         }else{ $account = ""; }
        }
        $desc = $Ntry->NtryDtls->TxDtls->AddtlTxInf; 
?>
        <tr>
        <td><?=$amount?></td>
        <td><?=$CdtDbt?></td>
        <td><nobr><?=$date?></nobr></td>
        <td><?=$name?></td>
        <td><?=$account?></td>
        <td><?=$desc?></td>
<?
        $transaction = new Transaction();
        $transaction->setSeq($seq);
        $transaction->setCdtDbt($CdtDbt);
        $transaction->setAccountNr($account);
        $transaction->setName($name);
        $transaction->setDescr($desc);
        $transaction->setDate($date);
        $transaction->setAmount($amount);
        try {
            $entityManager->persist($transaction);
            $entityManager->flush();
        } 
        catch (\Exception $e)
        {
            $code = $e->getMessage(); 
            echo "<td>Record exists</td>";
        }
    }
}
echo "</table>";
}
?>
</div>
<?include("sidemenu.php");?>
<div class="clear"> </div>

</div>

<div id="footer">

<div class="left">
</div>

<div class="right">
</div>

<div class="clear"> </div>

</div>

</body>
</html>
