/**
 * powered by php-shaman
 *  26.04.2016
 * stomat
 */

$("input[name=search_text]" ).autocomplete({
    source: "/subscribe/autocomplete/",
    minLength: 2
});

$('#sortform-sort').change(function(){
    $('#sort-form').submit();
});

$('#subscribe-ok').click(function(){
    var data = $('#subscribe-email').val();
    if(!data){
        alert('Нужно ввести Email!');
        return false;
    }
    $.ajax({
        type: "POST",
        url: "/subscribe/index/",
        data: {email : data},
        success: function(msg){
            if(!msg.e){
                $('#subscribe-email').val('');
            }
            alert(msg.t);
        }
    });
});