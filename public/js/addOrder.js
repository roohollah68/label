$(() => {
    let ids = [
        'name',
        'phone',
        'address',
        'zip_code',
        'orders',
        'desc',
    ]
    if (!edit)
        $("form").submit(function (e) {
            let data = {};
            ids.forEach(id => {
                data[id] = $("#" + id).val();
            })
            data['_token'] = $('input[name=_token]').val();
            $.post('add_order', data)
                .done(res => {
                    $.notify(res[0], res[1])
                    if (res[1] === 'success')
                        $('input[type=reset]').click();
                })
            return false;
        })


    invalid_messages()
})

function invalid_messages() {
    $('input , textarea').on('invalid', (e) => {
        if (e.target.validity.valueMissing) {
            e.target.setCustomValidity('پر کردن این قسمت اجباری است.');
        }

        if (e.target.validity.tooLong) {
            e.target.setCustomValidity('تعداد ارقام زیاد است.');
        }

        if (e.target.validity.tooShort) {
            e.target.setCustomValidity('تعداد ارقام کم است.');
        }

        if (e.target.validity.patternMismatch) {
            e.target.setCustomValidity('فقط عدد مجاز است.');
        }

    }).on('change , keypress , keydown', (e) => e.target.setCustomValidity(''))
}
