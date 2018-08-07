$(document).ready(function() {
    $('input').keypress(function(e){ 
        if(e.which == 42){
            return false;
        }
    });

});