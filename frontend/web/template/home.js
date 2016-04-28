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

$('#sortform-stock').change(function(){
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
        dataType: 'json',
        cache: false,
        success: function(msg){
            if(!msg.e){
                $('#subscribe-email').val('');
            }
            alert(msg.t);
        }
    });
});

$('#order-phone').inputmask("+38 (099) 999-99-99");
$('#userdescription-phone').inputmask("+38 (099) 999-99-99");

var cart = {

    dataCount: 0,
    dataItem: null,
    count: function(){
        var c = $('input[name=countItem]').val() * 1;
        if(c < 1){
            c = 1;
        }
        this.dataCount = c;
        return c;
    },
    add: function(id){
        this.count();
        this.dataItem = id;
        this.go();
        return false;
    },
    go: function(){
        var self = this;
        $.ajax({
            type: "POST",
            url: "/cart/add/",
            dataType: 'json',
            data: {count : self.dataCount, id : self.dataItem},
            cache: false,
            error: function(){
                alert('Произошла ошибка, обновите страницу и попробуйте еще раз.');
            },
            success: function(msg){
                if(!msg.e){
                    $('#cartItemCount').html(msg.count);
                }
                $('#cartAdd').modal('show');
            }
        });
    }
};