<?php
session_start();
include_once('includes/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>otp verification</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link href="css/sb-admin-2.min.css" rel="stylesheet">

<style type="text/css">
	#otpdiv{

		display: none;
	}
	#verifyotp{

		display: none;
	}
	#resend_otp{
		display: none;
	}

	.countdown{
		display: table;
		width: 100%;
		text-align: left;
		font-size: 15px;

	}

	#resend_otp:hover{

		text-decoration:underline;	

	}
</style>
</head>
<body>

<!-- Topbar -->
<?php include_once('includes/topbar2.php');?>
                <!-- End of Topbar -->
	

		<!--html part start-->
		
			
				<div  class="col-4 border p-4" style="margin-left: 29.5rem ;margin-top: 5rem;border-color:black!important">
					<div class="otp_msg"></div>
					<h1 class="text-center" style="color:#021326">OTP VERIFICATION</h1>
					<?php
						if(isset($_POST['sendotp'])){
							$mob=$_POST["mob"];
						}					
					?>
			<form action="new-user-testing.php" method="post">
			  <div class="form-group">
			    <label for="mobile">Enter Mobile Number</label>
			    <input type="text" class="form-control" id="mob" name="mob" pattern="[0-9]{10}" title="10 numeric characters only" placeholder="Enter mobile" onBlur="mobileAvailability()">
				<span id="mobile-availability-status" style="font-size:12px;"></span>
			   
			  </div>
			  <div class="form-group" id="otpdiv">
			    <label for="otp verification">Enter OTP</label>
			    <input type="text" class="form-control" id="otp" placeholder="Enter OTP">
			    <br>
			    <div class="countdown"></div>
				<a href="#" id="resend_otp" type="button">Resend</a>
			  </div>
			 
			  <button type="button" id="sendotp" name="sendotp" class="btn btn-primary">Send OTP</button>
			  <button type="button" id="verifyotp" class="btn btn-primary">Verify OTP</button>
			  
			</form>
				
			</div>
			<div style="margin-top:19rem;background-color:#081218">
				<?php include_once('includes/footer.php');?>
			</div>
			
	

		<!-- html part ends-->

		<script type="text/javascript">

function mobileAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'mobnumber='+$("#mob").val(),
type: "POST",
success:function(data){
$("#mobile-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
			
			$(document).ready(function(){


				function validate_mobile(mob){

					var pattern =  /^[6-9]\d{9}$/;

					if (mob == '') {

						return false;
					}else if (!pattern.test(mob)) {

						return false;
					}else{

						return true;
					}
				}


				//send otp function
				function send_otp(mob){

						var ch = "send_otp";
							
							$.ajax({

							url: "otp_process.php",
							method: "post",
							data: {mob:mob,ch:ch},
							dataType: "text",
							success: function(data){

								if (data == 'success') {

									$('#otpdiv').css("display","block");
									$('#sendotp').css("display","none");
									$('#verifyotp').css("display","block");
									
										timer();
									$('.otp_msg').html('<div class="alert alert-success">OTP sent successfully</div>').fadeIn();
										
										window.setTimeout(function(){
										$('.otp_msg').fadeOut();
									},1000)
										

								}else{

									$('.otp_msg').html('<div class="alert alert-danger">Error in sending OTP</div>').fadeIn();
										
										window.setTimeout(function(){
										$('.otp_msg').fadeOut();
									},1000)
								
								}
							}

						});
				}
				//end of send otp function


				//send otp function

				$('#sendotp').click(function(){

					var mob = $('#mob').val();

					

						if (validate_mobile(mob) == false) $('.otp_msg').html('<div class="alert alert-danger" style="position:absolute">Enter Valid mobile number</div>').fadeIn(); else 	send_otp(mob);

						window.setTimeout(function(){
							$('.otp_msg').fadeOut();
						},1000)
						
				
					    	
		

					});

				//end of send otp function


				//resend otp function
				$('#resend_otp').click(function(){

					var mob = $('#mob').val();
					
					send_otp(mob);
						$(this).hide();
				});
				//end of resend otp function


			//verify otp function starts

			$('#verifyotp').click(function(){
    var ch = "verify_otp";
    var otp = $('#otp').val();

    $.ajax({
        url: "otp_process.php",
        method: "post",
        data: {otp:otp,ch:ch},
        dataType: "text",
        success: function(data){
            if (data == "success") {
                $('.otp_msg').html('<div class="alert alert-success">OTP Verified successfully</div>').show().fadeOut(4000);
                // Redirect to dashboard.php if OTP is verified successfully
				var mobile = $('#mob').val();
                window.location.href = "new-user-testing.php?mob=" + encodeURIComponent(mobile);
            } else {
                $('.otp_msg').html('<div class="alert alert-danger">otp did not match</div>').show().fadeOut(4000);
            }
        }
    });
});



			//start of timer function

			function timer(){

					var timer2 = "00:31";
					var interval = setInterval(function() {


					  var timer = timer2.split(':');
					  //by parsing integer, I avoid all extra string processing
					  var minutes = parseInt(timer[0], 10);
					  var seconds = parseInt(timer[1], 10);
					  --seconds;
					  minutes = (seconds < 0) ? --minutes : minutes;
					  
					  seconds = (seconds < 0) ? 59 : seconds;
					  seconds = (seconds < 10) ? '0' + seconds : seconds;
					  //minutes = (minutes < 10) ?  minutes : minutes;
					  $('.countdown').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
					  //if (minutes < 0) clearInterval(interval);
					  if ((seconds <= 0) && (minutes <= 0)){
					  	clearInterval(interval);
					  	$('.countdown').html('');
					  	$('#resend_otp').css("display","block");
					  } 
					  timer2 = minutes + ':' + seconds;
					}, 1000);

				}

				//end of timer


			});
		</script>
</body>
</html>