// $(function () {
//     $("form").on('submit', function (e) {
//         e.preventDefault();
//         $.ajax({
//             url: "/clinic1/includes/post.php?tag="+$("#tag").val(),
//             type: "POST",
//             data: $(this).serialize(),
//             success: function(response) 
//             {
//                 var resp = JSON.parse(response);
//                 if (resp['success'] == 1)
//                 {
//                     document.location.href = 'dashboard.php';
//                 }
//                 else
//                 {
//                     $('#pop-modal').modal('show');
//                     $('#content').text(resp['msg']);
//                     $("input[name='user']").val("");
//                     $("input[name='pass']").val("");
//                 }
//             }
//         });
//     });
// });