$(function () {
    $('#subconnect').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "connexion.php",
            data: {
                "pseudo":$('#pseudo').val(),
                "pass":$('#password').val()
            },
            dataType: "text",
            success: function (response) {
                if (response =="ok"){
                    window.location.href = "index.php";
                }
                else $('.reponse').text(response);
                
            }
        });
    })
    $('#subsign').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "inscription.php",
            data: {
                "pseudo":$('#pseudo').val(),
                "pass":$('#password').val()
            },
            dataType: "text",
            success: function (response) {
                if (response =="ok"){
                    window.location.href = "index.php";
                }
                else $('.reponse').text(response);
                
            }
        });
    })
});