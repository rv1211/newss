<div class="footer text-muted">
	<span style="float: left;">
		Copyright &copy; <?php echo date("Y"); ?> ShipSecure
	</span>
    <span style="float: right; color: white">
    &nbsp;&nbsp;Powered by <a href="https://quickbookintegration.com/" target="_blank" style="color: white !important">Quickbook Integration</a>
  </span>
</div>
<!-- /footer -->
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.notifyBar.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form_select2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" defer></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/admin_custom_code.js?v=17.11"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form_validation.js?v=9"></script>

<?php if ($this->session->flashdata('message')) {?>
    <script type="text/javascript">
        $("#result").fadeIn("slow").append("<?php echo $this->session->flashdata('message'); ?>");
        setTimeout(function() {
            $("#result").fadeOut("slow");
        }, 4000);
    </script>
<?php } else {?>
    <script type="text/javascript">
        $("#result_error").fadeIn("slow").append("<?php echo $this->session->flashdata('error'); ?>");
        setTimeout(function() {
            $("#result_error").fadeOut("slow");
        }, 7000);
    </script>
<?php }?>
<script type="text/javascript">
    $(document).ready(function() {
       $(document).bind("contextmenu", function (e) {
            return false;
        });

        document.onkeydown = function (e) {
            if (e.ctrlKey &&
                (e.keyCode === 85 ||
                e.keyCode === 123 ||
                e.keyCode === 117)) {
                return false;
            } else if (e.keyCode == 123) {
                return false;
            }
            else if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                return false;
            }
            else {
                return true;
            }
        };

        $('a').click(function (e) {
            if (e.ctrlKey) {
                return false;
            }
        });


        $(':input').on('focus', function () {
            $(this).attr('autocomplete', 'off');
        });

    });
</script>
   </body></html>