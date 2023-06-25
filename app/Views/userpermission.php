<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<div id="wrapper">
<?php include APPPATH.'views/layouts/sidebar.php';?>
<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
    <?php include APPPATH.'views/layouts/breadcrumb.php';?>  
    <!-- Page Content -->
    <h1>User permission List</h1>
    <hr>

<script
src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email Id</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <?php foreach($users as $userdata) { ?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $userdata['id']; ?></th>
      <td><?php echo $userdata['firstname']." ".$userdata['lastname']; ?></td>
      <td><?php echo $userdata['email']; ?></td>
      <td>  
    <label class="checkbox-inline bootstrap-switch-noPad" >
    <input type="checkbox" data-toggle="toggle" value="<?php echo $userdata['role']; ?>" class="role_<?php echo $userdata['id']; ?>" data-size="xs" data-on="admin" data-off="user" data-onstyle="success" data-offstyle="danger" id="toggle_show_cancelled<?php echo $userdata['id']; ?>" name="recipients" <?php if($userdata['role'] == 'admin') { ?> checked = "checked" <?php } ?>>
    </label>

</td>
    </tr>
  </tbody>
  <script type="text/javascript">
    $("#toggle_show_cancelled<?php echo $userdata['id']; ?>").change(function(){
    if($(this).prop("checked") == true){
      var dataswitch = $(this).attr("data-on");
    }else{
      var dataswitch = $(this).attr("data-off");
    }
    console.log(dataswitch);
    var query = dataswitch;
    $.ajax({  
      url:'<?php echo base_url('changerole'); ?>',
      type: 'post',
      dataType:'json',
      data: {query: query, id: '<?php echo $userdata['id']; ?>'},
      success: function(response){
        var result = JSON.parse(response);
        console.log(response);
        console.log(result);
      },
      error: function(response){
        console.log(response);
      } 
    });
});

</script>
  <?php } ?>
    
</table>
</div>
</div>
</div>

<script type="text/javascript">
  
  // function demochange(sender, value){
  //   $(".role_"+value).prop("checked", sender.checked);

  //   var demolink = $(".role_"+value).attr('data-on');
  //   console.log($(".role_"+value).attr('checked'));
  //   var is_checked = $(".role_"+value).is(':checked');

  //   if($("#toggle_show_cancelled").attr("checked") == true){
  //     alert('vv');
  //   }else{
  //     alert('ss');
  //   }
  //   alert(demolink);
  // };
//   $.ajax({  
//     url:<?php echo base_url('changerole'); ?>,
//     type: 'post',
//     dataType:'json',
//     data:{query:query},
//     success:function(data){
//         alert(data);
//     }  
// });
  </script>
<?= $this->endSection() ?>
