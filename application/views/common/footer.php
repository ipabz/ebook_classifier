    <footer id="footer">
      &nbsp;
    </footer>
    <script>
      var site_url = '<?php print site_url(); ?>';
      var base_url = '<?php print base_url(); ?>';
      var class_name = '004';
      var __upload_url = site_url + "training/upload_files/";
      var upload_url = __upload_url + class_name;
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-1.11.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    
    <?php
    if (defined('TRAINING')) :
      // The below scripts is loaded only for pages that requires uploading of files.
      // This is to maintain fast loading of pages.
    ?>


    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="assets/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="assets/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="assets/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="assets/js/canvas-to-blob.min.js"></script>

    <!-- blueimp Gallery script -->
    <script src="assets/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="assets/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="assets/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="assets/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="assets/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="assets/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="assets/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="assets/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="assets/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <script src="assets/js/main.js?r=<?php print time(); ?>"></script>
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="assets/js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
    
    
    <?php
    endif;
    ?>
    
    <script type="text/javascript" src="assets/js/tablesorter.js"></script> 
    
    <script src="assets/js/custom.js?r=<?php print time(); ?>"></script>
  </body>
</html>