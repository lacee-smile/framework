$(function(){$("button").on("click",function()
{
  var username = $("[name='username']").val();
    var pw = $("[name='password']").val();
    $.post
    (
      "/home/login",
      {
        username: username,
        password: pw
      },
      function(data)
        {
          data = JSON.parse(data);
          if(!data[0])
            {
              // hibás jelszó kiírása
              $("#text").html("Hibás felhasználónév vagy jelszó!");
            }
          /*else 
            {
              location.reload();
            }*/
        }
    );
})});