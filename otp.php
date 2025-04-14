
<!DOCTYPE html>
<html>
<head>
	<title>otp</title>
	 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
		<!--html part start-->
		<div class="container p-3 my-3 border">
			<div class="row">
				<div  class="col-6 border border-success p-4 ml-2">
					<div class="otp_msg"></div>
					<h1 class="text-danger text-center">OTP VERIFICATION</h1>
			<form method="post">
			  <div class="form-group">
			    <label for="mobile">Enter Mobile Number</label>
			    <input type="text" class="form-control" id="mob"  placeholder="Enter mobile">
			   
			  </div>
			  <div class="form-group" id="otpdiv">
			    <label for="otp verification">Enter OTP</label>
			    <input type="text" class="form-control" id="otp" placeholder="Enter OTP">
			    <br>
			    <div class="countdown"></div>
				<a href="#" id="resend_otp" type="button">Resend</a>
			  </div>
			 
			  <button type="button" id="sendotp" class="btn btn-primary">Send OTP</button>
			  <button type="button" id="verifyotp" class="btn btn-primary">Verify OTP</button>
			  
			</form>
				</div>

				<div class="col-5 ml-2">
					
				</div>
			</div>

			
		</div>

		<!-- html part ends-->


		<!--script part start-->
		<script type="text/javascript">
			
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

				
				function send_otp(mob){

						var ch = "send_otp";
							$.ajax({

							url: "demo.php",
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

									$('.otp_msg').html('<div class="alert alert-danger">Error in sending OTP</div>');
										window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });
                        },2000);
								}
							}

						});
				}

					
				$('#resend_otp').click(function(){

					var mob = $('#mob').val();
					
					send_otp(mob);
						$(this).hide();
				});

				$('#sendotp').click(function(){

					var mob = $('#mob').val();

					// if (mob == '') {

					// 	$('.otp_msg').html('<div class="alert alert-danger">Enter Phone Number</div>');
					// }else{

					// 	send_otp(mob);
					// }

						if (validate_mobile(mob) == false) $('.otp_msg').html('<div class="alert alert-danger" style="position:absolute">Enter Valid mobile number</div>').fadeIn(); else 	send_otp(mob);

						window.setTimeout(function(){
							$('.otp_msg').fadeOut();
						},1000)
						
				
					    	
		

					});

				$('#verifyotp').click(function(){

						
						var ch = "verify_otp";
						var otp = $('#otp').val();

						$.ajax({

							url: "demo.php",
							method: "post",
							data: {otp:otp,ch:ch},
							dataType: "text",
							success: function(data){

									if (data == "success") {

										$('.otp_msg').html('<div class="alert alert-success">OTP Verified successfully</div>').show().fadeOut(4000);
																				
									}else{

										$('.otp_msg').html('<div class="alert alert-danger">otp did not match</div>').show().fadeOut(4000);
									}
							}
						});
								

				});


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

					
				


			});
		</script>
</body>
</html>