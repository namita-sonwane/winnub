/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var socket = io('node.winnub.com');

socket.emit('hello',user_winnub.guuid);


socket.on("benvenuti",function(msg){
    
    alert(msg);
    
});

socket.on('chat message', function(msg){
       
            $.notify({
                message: msg
            },{
                type: "chatmessage",
                placement: {
                        from: "top",
                        align: "right"
                }

            }
        );
});

socket.on('notification',function(msg) {
    // my msg
    console.log(msg);

    $.notify({
                message: msg.message
            },{
                type: msg.type,
                placement: {
                        from: "top",
                        align: "right"
                }

            }
    );


});

