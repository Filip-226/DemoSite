<?php
//include_once('config.php');

$conn = new mysqli('localhost', 'dpmya91d_cms', 'pw4cms1500DB', 'dpmya91d_cms1500');
//$id=$_POST['id'];
$client_id=$_POST['form_id'];
//echo $client_id;
$insure_id=$_POST['insured_id'];
$firstname = $_POST['patient_fname'];
$lastname = $_POST['patient_lname'];
$patientAddress = $_POST['patientAddress'];
$patientCity = $_POST['patientCity'];
$patientState = $_POST['patientState'];
$patientZip = $_POST['patientZip'];
$patientDOB = $_POST['patientDOB'];
$patientSex = $_POST['patientSex'];
$insure_planname = $_POST['insure_planname'];
$patientPhone = $_POST['patientPhone'];
$other_insuredid=$_POST['other_insuredid'];
$insured_lname=$_POST['insured_lname'];
$insuredAddress=$_POST['insuredAddress'];
$insured_CITY=$_POST['insured_CITY'];
$insured_STATE=$_POST['insured_STATE'];
$insured_ZIP=$_POST['insured_ZIP'];
$insured_PHONE=$_POST['insured_PHONE'];
$others_inname=$_POST['others_inname'];
$diag_CODEA=$_POST['diag_CODEA'];
$diag_CODEB=$_POST['diag_CODEB'];
$diag_CODEC=$_POST['diag_CODEC'];
$diag_CODED=$_POST['diag_CODED'];
$diag_CODEE=$_POST['diag_CODEE'];
$diag_CODEF=$_POST['diag_CODEF'];
$diag_CODEG=$_POST['diag_CODEG'];
$diag_CODEH=$_POST['diag_CODEH'];
$diag_CODEI=$_POST['diag_CODEI'];
$diag_CODEJ=$_POST['diag_CODEJ'];
$diag_CODEK=$_POST['diag_CODEK'];
$diag_CODEL=$_POST['diag_CODEL'];
$fedTAXID=$_POST['fedTAXID'];
$patientACCTNo=$_POST['patientACCTNo'];
$physicianSignDate=$_POST['physicianSignDate'];
$nopo=$_POST['nopo'];
$resubmissionCode=$_POST['resubmissionCode'];
$fd7=$_POST['fd7'];
$td7=$_POST['td7'];
$fd71=$_POST['fd71'];
$td71=$_POST['td71'];
$fd72=$_POST['fd72'];
$td72=$_POST['td72'];
$fd73=$_POST['fd73'];
$td73=$_POST['td73'];
$fd74=$_POST['fd74'];
$td74=$_POST['td74'];
$fd75=$_POST['fd75'];
$td75=$_POST['td75'];
$ser_pla=$_POST['ser_pla'];
$ser_pla1=$_POST['ser_pla1'];
$ser_pla2=$_POST['ser_pla2'];
$ser_pla3=$_POST['ser_pla3'];
$ser_pla4=$_POST['ser_pla4'];
$ser_pla5=$_POST['ser_pla5'];
$signedDate=$_POST['signedDate'];
$servicelocation=$_POST['servicelocation'];
$billingprovider=$_POST['billingprovider'];
$total_charge=$_POST['total_charge'];
$amount_paid=$_POST['amount_paid'];
$Rsvd=$_POST['Rsvd'];
$other_claimsID=$_POST['other_claimsID'];

$sql="INSERT INTO `claims` (`client_no`, `insuredIDNumber`, `patient_fname`, `patient_lname`, `patient_address`, `patient_city`, `patient_state`, `patient_zip`, `patient_dob`, `patient_sex`, `patient_insurancePlan`, `patient_phone`, `insured_id`, `insured_name`, `insured_address`, `insured_city`, `insured_state`, `insured_zip`, `insured_phone`, `others_inname`, `diag_codeA`, `diag_codeB`, `diag_codeC`, `diag_codeD`, `diag_codeE`, `diag_codeF`, `diag_codeG`, `diag_codeH`, `diag_codeI`, `diag_codeJ`, `diag_codeK`, `diag_codeL`, `federalTAXid`, `patient_acctno`, `signature_physicianDate`, `additionalClaimInfo`, `resubmissionCode`, `service_fromdate1`,`service_todate1`, `service_fromdate2`, `service_todate2`, `service_fromdate3`, `service_todate3`, `service_fromdate4`, `service_todate4`, `service_fromdate5`, `service_todate5`, `service_fromdate6`, `service_todate6`, `service_place1`, `service_place2`, `service_place3`, `service_place4`, `service_place5`, `service_place6`, `signed_date`, `service_location`, `billing_providerinfo`, `total_charge`, `amount_paid`, `business_id`, `otherclaimsID`) VALUES ('$client_id', '$insure_id', '$firstname', '$lastname', '$patientAddress', '$patientCity', '$patientState', '$patientZip', '$patientDOB', '$patientSex', '$insure_planname', '$patientPhone', '$other_insuredid', '$insured_lname', '$insuredAddress', '$insured_CITY', '$insured_STATE', '$insured_ZIP', '$insured_PHONE', '$others_inname', '$diag_CODEA', '$diag_CODEB', '$diag_CODEC', '$diag_CODED', '$diag_CODEE', '$diag_CODEF', '$diag_CODEG', '$diag_CODEH', '$diag_CODEI', '$diag_CODEJ', '$diag_CODEK', '$diag_CODEL', '$fedTAXID', '$patientACCTNo', '$physicianSignDate', '$nopo', '$resubmissionCode', '$fd7', '$td7', '$fd71', '$td71', '$fd72', '$td72', '$fd73', '$td73', '$fd74', '$td74', '$fd75', '$td75', '$ser_pla', '$ser_pla1', '$ser_pla2', '$ser_pla3', '$ser_pla4', '$ser_pla5', '$signedDate', '$servicelocation', '$billingprovider', '$total_charge', '$amount_paid', '$Rsvd', '$other_claimsID')";
 //echo $sql;
if ($conn->query($sql) == TRUE) {
    echo "data inserted";
}
else 
{
    echo "failed";
}
 
?>