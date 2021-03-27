$(function () {
    
    // événements déclencheurs ajax
    var username = "";
    function init(){

        
        $.ajax({
            type: "get",
            url: "exchange.php",
            data:"session="+"ok",
            dataType: "text",
            success: function (response) {
                $('#profileName').text(response);
                username = response;

            }
            
        });
        $.ajax({
            type: "get",
            url: "exchange.php",
            data: "which=all",
            dataType: "json",

            success: function (response) {
                displayMessages(response);
                scrollDown();
                
            },
            error: function(resultat,statut,erreur){
                console.log("il y a une erreur:"+resultat+statut+erreur);
            }

        });

        
        
    }
    
    function displayMessages(messages){
        let justContent;
        let posMess;
        let posAuth;
        for (var i=0; i < messages.length ;i++ ){
            justContent = (messages[i].author == username)? "j-end" :"j-start";
            posMess = (messages[i].author == username)? "mes-right" :"mes-left";
            posAuth = (messages[i].author == username)? "n-right" :"n-left";
            var content=
            '<div class="message-container '+justContent+'">'+
            '<div class="message '+posMess+'">'+
            '<div class="name '+posAuth+'">'+messages[i].author+'</div>'+
            messages[i].text+
            '<div class="date">'+messages[i].date+'</div>'+
            '</div>'+
            '</div>';
            $('#messagesWindow').append(content);
            scrollDown();   
        }
    }
        
    function scrollDown(){
        $($('#messagesWindow')).scrollTop(10000000);
    }
    $('#submit').click(function(e){
        e.preventDefault();
        ajaxSetMess();
    })
    $('#message').keydown(function (e) { 
        if(e.keyCode == 13) ajaxSetMess();
    });
    function ajaxSetMess(){
        $.post(
            "exchange.php", 
            {"text":$('#message').val()},
            function (reponse) {
                displayMessages(reponse);
                $('#message').val("");

            },
            "json"
        );
    }
    setInterval(function(){
        $.getJSON("exchange.php", "data=refresh",
            function (response) {
                if (response[0] == "null" ){
                    console.log("pas de nouveau message")
                }
                else{displayMessages(response)};
                
            }
        );

    },3000);   
        
        
    init();
        

});



