const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn bg-gradient-success',
    cancelButton: 'btn bg-gradient-danger'
  },
  buttonsStyling: false
});
const site_url = $("#site_url").val() + "/index.php/";
let csrf_token = $("#csrf_token").val();

$(function() {
  $(".btn-subscriber-delete").click(function() {
    var subscriber_id = $(this).data("subscriberid");
    var url = site_url + "subscriber/delete";
    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url:url,
          type:"POST",
          dataType:"json",
          data:{
            subscriber_id:subscriber_id,
            csrf_test_name : csrf_token
          },
          success:function(res) {
            if(res.status = "success") {
              Swal.fire({
                title:'Deleted!',
                text:'That subscriber has been deleted.',
                icon:'success'
              }).then(() => {
                window.location.reload();
              });
            } else {
              Swal.fire(
                'Fail!',
                'Something wrong!',
                'danger'
              );
            }
          }        
        });
      }
    });
  });

  $(".sector").change(function() {
    let sector = $(this).val();
    let url = $("#site_url").val() + "/sector/index?keyword=" + sector;
    window.location.href = url;
  });
});