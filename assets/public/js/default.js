$(function() {

    $.get('./xhrGetListings', function(o) {

        for (var i = 0; i < o.length; i++)
        {
            $('#listInserts').append('<div>' + o[i].text + '<a class="del" rel="'+ o[i].dataid +'" href="#">X</a></div>');
        }

        //$('.del').live('click', function() {
        $(document).on('click', '.del', function() {
            delItem = $(this);
            var id = $(this).attr('rel');
            var token = $('#csrf_code').attr('name');
            var csrf = $('#csrf_code').val();

            $.post('./xhrDeleteListing', {'id': id, [token]: csrf}, function(o) {
                //console.log('run post!');
                delItem.parent().remove();
                $('#csrf_code').val(o.csrf);
            }, 'json');

            return false;
        });

    }, 'json');


    $('#randomInsert').submit(function() {
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            $('#listInserts').append('<div>' + o.text + '<a class="del" rel="'+ o.id +'" href="#">X</a></div>');
            $('#csrf_code').val(o.csrf);
        }, 'json');

        return false;
    });


});
