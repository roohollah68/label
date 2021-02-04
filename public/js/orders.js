let token;
let table;
let orders, users;
let ids = [];
$(() => {
    token = $('input[name=_token]').val();
    $("#deleted_orders").checkboxradio();
    get_data();
})

function get_data() {
    let token = $('input[name=_token]').val();
    $.post('get_orders', {_token: token})
        .done(res => {
            orders = {};
            res[0].forEach(order => {
                orders[order.id] = order;
            })
            users = {};
            $('#user').html('<option value="all" selected>همه</option>');
            res[1].forEach(user => {
                users[user.id] = user;
                $('#user').append(`<option value="${user.id}">${user.name}</option>`)
            })
            ids = [];
            prepare_data();
            $('.main_check').prop('checked', false);
        })
}

function prepare_data() {
    let res = [];
    let counter = 0;
    let user = $('#user option:selected').val() || 'all';
    let website = $('#website option:selected').val() || 'all';
    let deleted = $("#deleted_orders").prop('checked');
    $.each(orders, (id, row) => {
        if (user !== 'all' && user != row.user_id)
            return
        if (website !== 'all' && website !== users[row.user_id].website)
            return
        if (deleted ^ !!row.deleted_at)
            return
        // console.log(deleted)
        // console.log(row.deleted_at)
        // console.log(deleted ^ !!row.deleted_at)

        counter++;
        res.push([
            `<input type="checkbox" class="orders_checkbox" onclick="list_ids()" order_id="${id}">`,

            counter,

            row.name,

            users[row.user_id].name,

            users[row.user_id].website,

            (row.orders.length > 30) ?
                row.orders.substr(0, 30) + ' ...'
                :
                row.orders,

            (row.desc.length > 30) ?
                row.desc.substr(0, 30) + ' ...'
                :
                row.desc,

            `<i class="fa fa-eye btn btn-info" onclick="view_order(${id})"></i> ` +
            ` <i class="fa fa-trash-alt btn btn-danger" onclick="delete_order(${id})" title="حذف سفارش" ></i>` +
            (deleted ? `
                    <i class="fa fa-trash-restore btn btn-primary" onclick="restore_order(${id})" title="بازگردانی"></i>
            ` : `
                    <a class="fa fa-edit btn btn-primary" href="edit_order/${id}" title="ویرایش سفارش"></a>`
            )
            +
            ` <i class="fa fa-file-pdf btn btn-secondary" onclick="generatePDF(${id})" title="مشاهده PDF"></i>`,

            row.address,

            row.desc,

            row.orders,

            row.phone,

            row.zip_code,

            id

        ])
    })
    create_table(res);
}

function create_table(data) {
    if (table)
        table.destroy();
    table = $('table').DataTable({
        columns: [
            {title: '<input type="checkbox" onclick="all_ids(this)" class="main_check">'},
            {title: "#"},
            {title: "نام"},
            {title: "سفیر"},
            {title: "فروشگاه"},
            {title: "سفارش"},
            {title: "توضیحات"},
            {title: "عملیات"},
            {title: "آدرس"},
            {title: "توضیحات"},
            {title: "سفارشات"},
            {title: "همراه"},
            {title: "کدپستی"},
            {title: "آیدی"},
        ],
        "columnDefs": [
            {
                "targets": [0, 1, 7],
                "searchable": false
            },
            {
                targets: [0, 5, 6, 8, 9, 10, 11, 12],
                orderable: false
            },

            {
                targets: [1,8, 9, 10, 11, 12,13],
                visible: false
            }
        ],
        data: data,
        order: [[13, "asc"]],
        language: {
            "decimal": "",
            "emptyTable": "هیچ سفارشی موجود نیست",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ مورد",
            "infoEmpty": "نمایش  0 تا 0 از 0 مورد",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "نمایش _MENU_ مورد",
            "loadingRecords": "در حال بارگذاری...",
            "processing": "در حال پردازش...",
            "search": "جستجو:",
            "zeroRecords": "هیچ مورد منطبقی یافت نشد",
            "paginate": {
                "first": "اولین",
                "last": "آخرین",
                "next": "بعدی",
                "previous": "قبلی"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });

}

function delete_order(id) {
    orders[id].deleted_at ?
        confirm("برای همیشه حذف شود؟") ?
            $.post('delete_order/' + id, {_token: token})
                .done(res => {
                    $.notify(res, 'info');
                    get_data();
                })
            : ''
        :
        ($.post('delete_order/' + id, {_token: token})
            .done(res => {
                $.notify(res, 'info');
                get_data();
            }))
}

function delete_orders() {
    if (ids.length === 0) {
        $.notify('ابتدا باید سفارشات مورد نظر را انتخاب کنید', 'error')
        return
    }
    orders[ids[0]].deleted_at ?
        confirm("برای همیشه حذف شوند؟") ?
            $.post('delete_orders', {_token: token, ids: ids})
                .done(res => {
                    get_data();
                })
            :
            ""
        :
        $.post('delete_orders', {_token: token, ids: ids})
            .done(res => {
                get_data();
            })
}

function restore_order(id) {
    $.post('restore_order/' + id, {_token: token})
        .done(res => {
            $.notify(res, 'info');
            get_data();
        })
}

function list_ids() {
    setTimeout(() => {
        ids = [];
        $.each($('.orders_checkbox:checked'), (key, value) => {
            ids.push($(value).attr('order_id'))
        })
    }, 100)
}

function all_ids(box) {
    setTimeout(() => {
        $('.orders_checkbox').prop('checked', false);
        if (box.checked)
            $('.orders_checkbox').prop('checked', true);
        list_ids()
    }, 100)
}

function view_order(id) {
    let row = orders[id]

    let dialog = `
    <div title="مشاهده سفارش" class="dialogs">
    <span>نام و نام خانوادگی:</span> <b>${row.name}</b> <br>
    <span>شماره تماس:</span> <b>${row.phone}</b> <br>
    <span>آدرس:</span> <b>${row.address}</b> <br>
    <span>کد پستی:</span> <b>${row.zip_code}</b> <br>
    <span>سفارشات:</span> <b>${row.orders}</b> <br>
    <span>توضیحات:</span> <b>${row.desc}</b> <br>
    <span>زمان ثبت:</span> <b>${row.created_at_p}</b> <br>
    <span>زمان آخرین ویرایش:</span> <b>${row.updated_at_p}</b> <br>` +
        (row.deleted_at_p ?
                `<span>زمان حذف:</span> <b>${row.deleted_at_p}</b> <br>`
                :
                ""
        ) + `

</div>
    `;
    $(dialog).dialog({
        modal: true,
        open: () => {
            $('.ui-dialog-titlebar-close').hide();
            $('.ui-widget-overlay').bind('click', function () {
                $(".dialogs").dialog('close');
            });
        }
    });

}

function generatePDF(id) {
    let row = orders[id];
    let dialog = `
<div class="printed">
    <span>نام و نام خانوادگی </span>: <b>${fix_persian(row.name)}</b> <br>
    <span>شماره تماس </span>: <b>${row.phone}</b> <br>
    <span>آدرس </span>: <b>${fix_persian(row.address)}</b> <br>
    <span>کد پستی </span>: <b>${row.zip_code}</b> <br>
    <span>سفارشات </span>: <b>${fix_persian(row.orders)}</b> <br>
    <span>توضیحات </span>: <b>${fix_persian(row.desc)}</b>
</div>
    `;
    console.log(dialog);
    let opt = {
        margin: 0.6,
        image: {type: 'jpeg', quality: 1},
        filename: row.name + '_' + row.id + '.pdf',
        jsPDF: {format: [30, 15], unit: 'cm', orientation: 'l'}
    };
    html2pdf()
        .set(opt)
        .from(dialog)
        .save();
}

function generatePDFs() {
    if (ids.length === 0) {
        $.notify('ابتدا باید سفارشات مورد نظر را انتخاب کنید', 'error')
        return
    }
    let dialog = [];
    ids.forEach(id => {
        let row = orders[id]
        dialog.push(`
<div class="printed">
    <span>نام و نام خانوادگی </span>: <b>${fix_persian(row.name)}</b> <br>
    <span>شماره تماس </span>: <b>${row.phone}</b> <br>
    <span>آدرس </span>: <b>${fix_persian(row.address)}</b> <br>
    <span>کد پستی </span>: <b>${row.zip_code}</b> <br>
    <span>سفارشات </span>: <b>${fix_persian(row.orders)}</b> <br>
    <span>توضیحات </span>: <b>${fix_persian(row.desc)}</b>
</div>
    `);
    })
    dialog = dialog.join('<br class="breakhere">')
    let opt = {
        margin: 0.6,
        image: {type: 'jpeg', quality: 1},
        filename: 'سفازشات.pdf',
        pagebreak: {after: '.breakhere'},
        jsPDF: {format: [30, 15], unit: 'cm', orientation: 'l'}
    };
    html2pdf()
        .set(opt)
        .from(dialog)
        .save();
}

function fix_persian(text) {
    let symbols = [",", ".", "-", "_", "#", "@", "(", ")", "{", "}", "[", "]", "،", "$",];
    symbols.forEach(symbol => {
        text = text.split(symbol).join("</b>" + symbol + "<b>")
    })
    return text
}