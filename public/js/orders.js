let token;
let table;
let deleted = false;
let orders;
let ids = [];
$(() => {
    token = $('input[name=_token]').val();
    $("#deleted_orders").checkboxradio();
    get_data();
})

function get_data() {
    let token = $('input[name=_token]').val();
    $.post('get_orders', {_token: token, deleted: deleted})
        .done(res => {
            orders = res;
            prepare_data();
        })
}

function prepare_data() {
    let res = [];
    orders.forEach((row, key) => {
        res.unshift([
            `<input type="checkbox" class="orders_checkbox" onclick="list_ids()" order_id="${row.id}">`,
            key + 1,
            row.name,
            row.orders,
            row.desc,
            `<i class="fa fa-eye btn btn-info" onclick="view_order(${row.id})"></i>`,
            ` <i class="fa fa-trash-alt btn btn-danger" onclick="delete_order(${row.id})" title="حذف سفارش" ></i>` +
            (deleted ?`
                    <i class="fa fa-trash-restore btn btn-primary" onclick="restore_order(${row.id})" title="بازگردانی"></i>
            `:`
                    <a class="fa fa-edit btn btn-primary" href="edit_order/${row.id}" title="ویرایش سفارش"></a>`
            )
            +
            ` <i class="fa fa-file-pdf btn btn-secondary" onclick="generatePDF(${row.id})" title="مشاهده PDF"></i>`
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
            {title: "سفارش"},
            {title: "توضیحات"},
            {title: "مشاهده"},
            {title: "عملیات"},
        ],
        data: data,
    });
    $('.main_check').attr('checked',false);
}

function delete_order(id) {
    $.post('delete_order/' + id, {_token: token, deleted: deleted})
        .done(res => {
            $.notify(res, 'info');
            get_data();
        })
}

function delete_orders() {
    $.post('delete_orders', {_token: token, deleted: deleted, ids: ids})
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
        $('.orders_checkbox').attr('checked', false);
        if (box.checked)
            $('.orders_checkbox').attr('checked', true);
        list_ids()
    }, 100)
}

function view_order(id) {
    let row
    orders.forEach(order => {
        if (order.id == id) {
            row = order;
            return;
        }
    })
    let dialog = `
    <div title="مشاهده سفارش" class="dialogs">
    <span>نام و نام خانوادگی:</span> <b>${row.name}</b> <br>
    <span>شماره تماس:</span> <b>${row.phone}</b> <br>
    <span>آدرس:</span> <b>${row.address}</b> <br>
    <span>کد پستی:</span> <b>${row.zip_code}</b> <br>
    <span>سفارشات:</span> <b>${row.orders}</b> <br>
    <span>توضیحات:</span> <b>${row.desc}</b> <br>
    <span>زمان ثبت:</span> <b>${row.created_at}</b> <br>
    <span>زمان آخرین ویرایش:</span> <b>${row.updated_at}</b> <br>
    <span>زمان حذف:</span> <b>${row.deleted_at}</b> <br>
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
    let row
    orders.forEach(order => {
        if (order.id == id) {
            row = order;
            return;
        }
    })
    let dialog = `
    <div title="مشاهده سفارش" class="dialogs">
    <span>نام و نام خانوادگی:</span> <b>${row.name}</b> <br>
    <span>شماره تماس:</span> <b>${row.phone}</b> <br>
    <span>آدرس:</span> <b>${row.address}</b> <br>
    <span>کد پستی:</span> <b>${row.zip_code}</b> <br>
    <span>سفارشات:</span> <b>${row.orders}</b> <br>
    <span>توضیحات:</span> <b>${row.desc}</b> <br>
    <span>زمان ثبت:</span> <b>${row.created_at}</b> <br>
    <span>زمان آخرین ویرایش:</span> <b>${row.updated_at}</b> <br>
    <span>زمان حذف:</span> <b>${row.deleted_at}</b> <br>
</div>
    `;
    html2pdf()
        .from(dialog)
        .save();
}
