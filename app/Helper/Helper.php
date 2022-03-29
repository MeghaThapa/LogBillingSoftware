<?php
use Illuminate\Support\Facades\DB;


function fiscal_year(){
$fiscalYear = DB::table('Settings')->get('fiscal_year')->first();
$extractedVal=str_split($fiscalYear->fiscal_year,2);

return $extractedVal;
}
function purchase_invoice(){
    $invoice_number = DB::table('Settings')->get('purchase_bill_number')->first();

    $fiscalYear=fiscal_year();
    $zero=str_pad($invoice_number->purchase_bill_number,5,'0',STR_PAD_LEFT);
    $purchase_invoice="0$fiscalYear[0]/0$fiscalYear[1]/$zero";
    return  $purchase_invoice;
}

?>