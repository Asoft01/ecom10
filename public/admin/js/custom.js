$(document).ready(function(){
    // check admin password is correct or not 
    $("#current_pwd").keyup(function(){
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            type: 'post', 
            url: '/admin/check-current-password', 
            data : { current_pwd : current_pwd }, 
            success: function(){
                if(resp == "false"){
                    $("#verifyCurrentPwd").html("Current Password is incorrect!");
                }else if(resp == "true"){
                    $("#verifyCurrentPwd").html("Current Password is Correct");
                }
            }, error:function(){
                alert("Error"); 
            }
        })
    });

    // Update CMS Page Status 
    $(document).on("click", ".updateCmsPageStatus", function(){
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id"); 
        alert(page_id); 
        ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            type: 'post', 
            url: '/admin/update-cms-pages-satus',
            data: {status: status, page_id: page_id}, 
            success: function(resp){
                
            }, error: function(){
                alert("Error");
            }
        })
    });
});