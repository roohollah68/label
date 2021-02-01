$(() => {
    let ids = [
        'name',
        'phone',
        'address',
        'zip_code',
        'orders',
        'desc',
    ]

    $("form").submit(function (e) {
        let data = {};
        ids.forEach(id=>{
            data[id] = $("#"+id).val();
        })
        data['_token'] = $('input[name=_token]').val();
        $.post('add_order',data)
            .done(res=>{
                $.notify(res[0] , res[1])
                if (res[1]==='success')
                    $('input[type=reset]').click();
            })
        return false;
    })


})
