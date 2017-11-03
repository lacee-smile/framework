/*$(function(){$("button").on("click",function()
{
	var username = $("[name='username']").val();
    var pw = $("[name='password']").val();

    $.ajax
    ({
        type: "POST",
        url: window.location.href,
        data: 'username=' + username + "&password=" + pw,
        success: function(success)
            {
                alert('sikeres');
            },
        failed: function(success)
        {
            alert("Connection error");
        }
    });
})});*/