<footer class="site-footer footer-content-dark bg-light pt-md-4 pb-md-3" id='page-footer'>
	<div class="container">
		<div class="row footer-row">
			<div class="col-lg-4 col-md-12">
				<h4 class="mb-4">Ahmedabad (CorporateOffice)</h4>
				<ul class="listing iconlist footer-col-1">
					<li class="mb-2"><i class="fa fa-map-marker"></i> <a> Ahmedabad, Gujarat</a></li>
					<li class="mb-2"><i class="fa fa-map-marker"></i> <a>Surat, Gujarat </a></li>
				</ul>
			</div>
			<div class=" col-lg-4 col-md-12 links landscape">
				<h4 class="mb-4">Quick Links</h4>
				<ul class="listing squarelist">
					<li><a href="#">Features</a></li>
					<li><a href="#">Facts</a></li>
					<li><a href="#">FAQ</a></li>
					<li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
					<li><a href="<?php echo base_url('terms-conditions'); ?>">Terms and Conditions</a></li>
					<li><a href="<?php echo base_url('disclaimer'); ?>">Disclaimer</a></li>
					<li><a href="#">Become a partner</a></li>
				</ul>
			</div>
			<div class="col-lg-4 col-md-12 links compact">
				<h4 class="mb-0 pb-4" data-toggle="collapse" data-target="#links" id='ql-mob'>Quick Links <i class='fa fa-caret-down' style='float:right;' id='ql-icon'></i></h4>
				<div id="links" class="collapse">
					<ul class="listing squarelist">
						<li><a href="#">Features</a></li>
						<li><a href="#">Facts</a></li>
						<li><a href="#">FAQ</a></li>
						<li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
						<li><a href="<?php echo base_url('terms-conditions'); ?>">Terms and Conditions</a></li>
						<li><a href="<?php echo base_url('disclaimer'); ?>">Disclaimer</a></li>
						<li><a href="#">Become a partner</a></li>
					</ul>
				</div>
			</div>
			<div class=" col-lg-4 col-md-12">
				<h4 class="mb-4">Track Your Order</h4>
				<div class="form-group">
					<form method="post" name="track-order-form" action="<?php echo base_url('track-order#track_detail_div'); ?>" data-parsley-validate>
						<input type="text" name="tracking_number" placeholder="Enter Airwaybill Number" class="form-control fc-bordered required" style="border: 1px solid #5C94A3;" data-parsley-required="true" required=""><br />
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-border footer-btn" type="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row copyright-row">
			<div class="col-lg-12 col-md-12 mt-3">
				<span class="copyright mb-3">Copyright &copy; <?php echo date("Y"); ?> ShipSecure. All Rights Reserved. <span style="color: white"> Powered by <a href="https://quickbookintegration.com/" target="_blank" style="color: white !important">Quickbook Integration</a></span></span>
				<ul>
					<li><a title="Facebook" href="#"><i class="fa fa-facebook-square"></i></a></li>
					<li><a title="Youtube" href="#"><i class="fa fa-youtube-play"></i></a></li>
					<li><a title="Twitter" href="#"><i class="fa fa-twitter-square"></i></a></li>
					<li><a title="Linkedin" href="#"><i class="fa fa-linkedin-square"></i></a></li>
					<li><a title="Instagram" href="#"><i class="fa fa-instagram"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/jquery.validate.min.js" defer></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/parsley.min.js" defer></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/front_custom_code.js?v=5.1"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/form_validation.js?v=8.2"></script>
<script async src="<?php echo base_url(); ?>assets/front-end/js/theme.js"></script>
<script>
	window.dataLayer = window.dataLayer || [];

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());
	gtag('config', 'UA-100370319-3');
</script>
<script>
	$(window).scroll(function() {
		$(window).scrollTop() >= 200 ? $(".backtotop").addClass("active") : $(".backtotop").removeClass("active")
	});
	var lastScrollTop = 0;
	$(window).scroll(function(l) {
		var o = $(this).scrollTop(),
			t = $("#page-content").offset().top,
			n = $("#page-footer").offset().top;
		o > lastScrollTop && t < o && o < n ? $("#client-login-m-btn").removeClass("cl-hide-btn") : $("#client-login-m-btn").addClass("cl-hide-btn"), lastScrollTop = o
	});
	$(".backtotop").click(function() {
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
		return false;
	});
</script>
<script src="<?php echo base_url(); ?>assets/front-end/js/lozad.min.js"></script>
<script>
	const observer = lozad('.lozad', {
		threshold: 0.05
	});
	observer.observe();
	// ONE SIGNAL
	var OneSignal = window.OneSignal || [];
	OneSignal.push(function() {
		OneSignal.init({
			appId: "454afd72-e5f6-46f9-9700-4aa32c029933",
		});
	});
</script>
<style>
	@import "//fonts.googleapis.com/css?family=Open+Sans:400,700%7CMontserrat:500,700";
</style>
<script>
	$('.nav-toggle').click(function() {
		$(this).toggleClass('open');
		if ($(this).hasClass('open')) {
			$(".nav-block-custom").css('height', $(".nav-block-custom").get(0).scrollHeight);
		} else {
			$(".nav-block-custom").css('height', 0);
		}
	});
</script>

<?php if ($this->session->flashdata('message')) { ?>
	<script type="text/javascript">
		$("#result").fadeIn("slow").append("<?php echo $this->session->flashdata('message'); ?>");
		setTimeout(function() {
			$("#result").fadeOut("slow");
		}, 4000);
	</script>
<?php } else { ?>
	<script type="text/javascript">
		$("#result_error").fadeIn("slow").append("<?php echo $this->session->flashdata('error'); ?>");
		setTimeout(function() {
			$("#result_error").fadeOut("slow");
		}, 7000);
	</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).bind("contextmenu", function(e) {
			return false;
		});

		document.onkeydown = function(e) {
			if (e.ctrlKey &&
				(e.keyCode === 85 ||
					e.keyCode === 123 ||
					e.keyCode === 117)) {
				return false;
			} else if (e.keyCode == 123) {
				return false;
			} else if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
				return false;
			} else {
				return true;
			}
		};

		$('a').click(function(e) {
			if (e.ctrlKey) {
				return false;
			}
		});


		$(':input').on('focus', function() {
			$(this).attr('autocomplete', 'off');
		});

	});


	$(".newclass").click(function(e) {
		$('li.active').removeClass('active');
		var $parent = $(this).parent();
		$parent.addClass('active');
	});
</script>
</body>

</html>
