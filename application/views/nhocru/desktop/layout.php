<!DOCTYPE html>
<html>
<head>  
  <title>Trắc Nghiệm</title>
  <?php $this->load->view(strtolower($interface.'/'.__CLASS__)."header") ?> 
  <script type="text/javascript">   
    $(document).ready(function () {
      $('#clear').click(function () {
        fd = new FormData();
        fd.append('clear','true');
        $.ajax({
          url: "<?php echo base_url() ?>clear",
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          type: 'POST',
          success: function(data){
            alert(data.message);
            window.location.href = '<?php echo base_url() ?>';
          },error: function() { }
        });
      });
    });
  </script>  
</head>
<body>
<?php echo $content_for_layout;?>
</body>
</html>