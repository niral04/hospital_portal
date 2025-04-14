<?php 
session_start();
error_reporting(0);
//DB conncetion
include_once('includes/config.php');

if(isset($_POST['submit'])){
//getting post values
$fname=$_POST['fullname'];
$mnumber=$_GET['mob'];
$dob=$_POST['dob'];
$govtid=$_POST['govtissuedid'];
$govtidnumber=$_POST['govtidnumber'];
$address=$_POST['address'];
$state=$_POST['state'];
$testtype=$_POST['testtype'];
$timeslot=$_POST['birthdaytime'];
$orderno= mt_rand(100000000, 999999999);
$query="insert into tblpatients(FullName,MobileNumber,DateOfBirth,GovtIssuedId,GovtIssuedIdNo,FullAddress,State) values('$fname','$mnumber','$dob','$govtid','$govtidnumber','$address','$state');";
$query.="insert into tbltestrecord(PatientMobileNumber,TestType,TestTimeSlot,OrderNumber) values('$mnumber','$testtype','$timeslot','$orderno');";
$result = mysqli_multi_query($con, $query);
if ($result) {
echo '<script>alert("Your test request submitted successfully. Order number is "+"'.$orderno.'")</script>';
  echo "<script>window.location.href='new-user-testing.php'</script>";
} 
else {
    echo "<script>alert('Something went wrong. Please try again.');</script>";  
echo "<script>window.location.href='new-user-testing.php'</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hospital Portal | New User Testing</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
<style type="text/css">
label{
    font-size:16px;
    font-weight:bold;
    color:#000;
}

</style>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php include_once('includes/sidebar2.php');?>
    
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" >
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
			  <br>
                    <h1 class="h3 mb-4 text-gray-800" id="new_head">Sample Testing</h1>
<form name="newtesting" method="post">
  <div class="row">

                        <div class="col-lg-6">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                                </div>
                                <div class="card-body">
                        <div class="form-group">
                            <label>Full Name</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname"  placeholder="Enter your full name..." pattern="[A-Za-z ]+" title="letters only" required="true">
                                        </div>
                                        <div class="form-group">
                                             <label>Mobile Number</label>
                                  <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo $_GET['mob']?>" required="true" readonly>
                                          
                                        </div>
                                        <div class="form-group">
                                             <label>DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" required="true">
                                        </div>
                                        <div class="form-group">
                                               <label>Any Govt Issued ID</label>
                                            <input type="text" class="form-control" id="govtissuedid" name="govtissuedid" placeholder="Pancard / Driving License / Voter id / any other" required="true">
                                        </div>
                                        <div class="form-group">
                                              <label>Govt Issued ID Number</label>
                                            <input type="text" class="form-control" id="govtidnumber" name="govtidnumber" placeholder="Enter Government Issued ID Number" required="true">
                                        </div>
                          

                               <div class="form-group">
                                              <label>Address</label>
                                            <textarea class="form-control" id="address" name="address" required="true" placeholder="Enter your full addres here"></textarea>
                                        </div>
 <div class="form-group">
                                              <label>State</label>
                                      <input type="text" class="form-control" id="state" name="state" placeholder="Enter your State Here" required="true">
                                        </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                           <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Testing Information</h6>
                                </div>
                                <div class="card-body">
                                <div class="form-group">
  <label>Test Type</label>
  <select class="form-control" id="testtype" name="testtype" required="true" onchange="showTests()">
    <option value="">Select</option>
    <option value="Blood">Blood</option>  
    <option value="Urine">Urine Test</option>
    <option value="STI/STD">STI/STD Test</option> 
    <option value="Allergy">Allergy Test</option> 
    <option value="vitamin & miniral">Vitamin & Miniral Test</option> 
    <option value="Pregnancy">Pregnancy Test</option>
    <option value="cancer">Cancer Screening Test</option> 
    <option value="covid">Covid Test</option>

  </select>
</div>

<div id="bloodTests" style="display:none">
  <label>Blood Tests</label>
  <select class="form-control">
    <option value="CBC">CBC Test</option>  
    <option value="DMP">DMP Test</option>
    <option value="CMP">CMP Test</option>
    <option value="Lipid Panel">Lipid Panel</option>  
    <option value="Thyroid Panel">Thyroid Panel</option>
    <option value="Iron Panel">Iron Panel</option>  
    <option value="Glucose Test">Thyroid Test</option>  
  </select>
</div>

<div id="urineTests" style="display:none">
  <label>Urine Tests</label>
  <select class="form-control"> 
    <option value="urinalysis">Urinalysis</option>  
    <option value="urine culture">Urine culture</option>
    <option value="Drug screening">Drug screening</option> 
  </select>
</div>

<div id="STITests" style="display:none">
  <label>STI/STD Tests</label>
  <select class="form-control"> 
    <option value="Gonorrhea">Gonorrhea</option>  
    <option value="Chlamydia">Chlamydia</option>
    <option value="HIV">HIV Test</option>
    <option value="Herpes">Herpes</option>  
    <option value="Syphilis">Syphilis</option> 
  </select>
</div>

<div id="allergyTests" style="display:none">
  <label>Allergy Tests</label>
  <select class="form-control">
    <option value="Skin Prick">Skin Prick Test</option>  
    <option value="blood allergy">Blood Test</option> 
  </select>
</div>

<div id="vitamin" style="display:none">
  <label>Vitamin And Miniral Tests</label>
  <select class="form-control"> 
    <option value="VitaminD">VitaminD</option>  
    <option value="VitaminB12">VitaminD</option>
    <option value="Iron">Iron</option>
    <option value="Magnesium">Magnesium Test</option>  
  </select>
</div>

<div id="Pregnancy" style="display:none">
  <label>Pregnancy Tests</label>
  <select class="form-control"> 
    <option value="urine pregnancy">Urine Test</option>  
    <option value="Blood pregnancy">Blood Test</option>
  </select>
</div>

<div id="cancer" style="display:none">
  <label>Cancer Screening Tests</label>
  <select class="form-control"> 
    <option value="colonoscopy">Colonoscopy</option>  
    <option value="mammogram">Mammogram</option>
    <option value="Pap Smear">Pap Smear</option> 
  </select>
</div>

<div id="covid" style="display:none">
  <label>Covid</label>
  <select class="form-control"> 
    <option value="PCR">PCR</option>  
    <option value="Rapid Antigen">Rapid Antigen</option>
    <option value="Antibody">Antibody Test</option> 
  </select>
</div>


<script>
function showTests() {
  var selectedOption = document.getElementById("testtype").value;
  if(selectedOption == "Blood") {
    document.getElementById("bloodTests").style.display = "block";
  }
  else {
    document.getElementById("bloodTests").style.display = "none";
  }
  if(selectedOption == "Urine") {
    document.getElementById("urineTests").style.display = "block";
  }
  else {
    document.getElementById("urineTests").style.display = "none";
  }
  if(selectedOption == "STI/STD") {
    document.getElementById("STITests").style.display = "block";
  }
  else {
    document.getElementById("STITests").style.display = "none";
  }
  if(selectedOption == "Allergy") {
    document.getElementById("allergyTests").style.display = "block";
  }
  else {
    document.getElementById("allergyTests").style.display = "none";
  }
  if(selectedOption == "vitamin & miniral") {
    document.getElementById("vitamin").style.display = "block";
  }
  else {
    document.getElementById("vitamin").style.display = "none";
  }
  if(selectedOption == "Pregnancy") {
    document.getElementById("Pregnancy").style.display = "block";
  }
  else {
    document.getElementById("Pregnancy").style.display = "none";
  }
  if(selectedOption == "cancer") {
    document.getElementById("cancer").style.display = "block";
  }
  else {
    document.getElementById("cancer").style.display = "none";
  }
  if(selectedOption == "covid") {
    document.getElementById("covid").style.display = "block";
  }
  else {
    document.getElementById("covid").style.display = "none";
  }
}
</script>

<div class="form-group">
    <br>
    <label>Time Slot for Test</label>
    <input type="datetime-local" class="form-control" id="birthdaytime" name="birthdaytime" class="form-control" min="<?php echo date('Y-m-d\TH:i'); ?>">
</div>
                       <div class="form-group">
                                 <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" id="submit">                           
                             </div>

                                </div>
                            </div>
                       

                        </div>

                    </div>
</form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

           <?php include_once('includes/footer.php');?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>