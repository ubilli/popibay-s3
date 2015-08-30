<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to Popibay.</title>

<!-- Fontawesome -->
<link href="http://popibay.com/pb-assets/frameworks/font-awesome/css/font-awesome.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="http://popibay.com/pb-assets/css/email.css" />

<link rel="stylesheet" type="text/css" href="http://popibay.com/pb-assets/css/pbemail.css" />

</head>
 
<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#cccc33">
	<tr>
		<td></td>
		<td class="header container" >
				
				<div class="content">
				<table bgcolor="#cccc33">
					<tr>
						<td><img src="http://popibay.com/pb-assets/img/logo/logo/popibayico32png.png" /></td>
						<td align="right"><h6 class="collapse">Welcome</h6></td>
					</tr>
				</table>
				</div>
				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table>
				<tr>
					<td>
						<h3 id="welcome_user">Hi, {{ $pb_username }}</h3>
						<p class="lead">Welcome to Popibay.</p>
						<p>Popibay is a on-line auctioning, Market, Pet management, Pet Breeding and Pet profiling application that manages the Pet business from the Pet manager to the Pet buyer, Also it manages the life cycle of the pet from the puppy/kitten stage to the stage which it ready to be sold out to Pet buyers, the auctioning bidders or direct buyers, which notifies it buyers about each and every process of the pet.</p>
						<!-- Callout Panel -->
						<p class="callout">
							Verify Your Email Address <a href="{{ URL::to('confirm/registration/' . $confirmation_code) }}">Click this link.</a>
						</p><!-- /Callout Panel -->					
												
						<!-- social & contact -->
						<table class="social" width="100%">
							<tr>
								<td>
									
									<!-- column 1 -->
									<table align="left" class="column">
										<tr>
											<td>				
												
												<h5 class="">Connect with Us:</h5>
												<p>
							<a href="#"><i class="fa fa-facebook fa-2x"></i></a> |
							<a href="#"><i class="fa fa-twitter fa-2x"></i></a> |
							<a href="#"><i class="fa fa-instagram fa-2x"></i></a>
							|
							<a href="#"><i class="fa fa-google-plus fa-2x"></i></a>
						</p>
						
												
											</td>
										</tr>
									</table><!-- /column 1 -->	
									
									<!-- column 2 -->
									<table align="left" class="column">
										<tr>
											<td>				
																			
												<h5 class="">Contact Info:</h5>												
												<p>Phone: <strong>408.341.0600</strong><br/>
                Email: <strong><a href="emailto:hseldon@trantor.com">hseldon@trantor.com</a></strong></p>
                
											</td>
										</tr>
									</table><!-- /column 2 -->
									
									<span class="clear"></span>	
									
								</td>
							</tr>
						</table><!-- /social & contact -->
						
					</td>
				</tr>
			</table>
			</div><!-- /content -->
									
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			
				<!-- content -->
				<div class="content">
				<table>
				<tr>
					<td align="center">
						<p>
							<a href="#">Terms</a> |
							<a href="#">Privacy</a> |
							<a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
						</p>
					</td>
					<td align="center">
						<p>
							Copyright Popibay 2015.
						</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->
				
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>