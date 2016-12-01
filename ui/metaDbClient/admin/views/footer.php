<!-- FOOTER -->
    <div id="footer">
    	<div class="wrapper">
        	<h2><a href="/" title="Omatech">Omatech</a></h2>
            <ul>
            	<li><a href="http://www.omatech.com" title="www.omatech.com">www.omatech.com</a></li>
            	<li><a href="mailto:info@omatech.com" title="info@omatech.com">info@omatech.com</a></li>
            	<li><span>93 219 77 63</span></li>
            </ul>
        </div>
    </div>
    <!-- /end FOOTER -->
    <div id="fosc_upload"></div>
    <div id="upload-popup1" class="upload-popup" style="z-index:9999;">  </div>
    <div id="browse-popup1" class="browse-popup" style="z-index:9999;">  </div>
    <script type="text/javascript">
	<?php
		if(isset($_SESSION['slide_status']) && $_SESSION['slide_status']=="close") echo 'amagar();';
	?>
    </script>

  <?php echo $autocomplete_str?>
  
</body>
</html>