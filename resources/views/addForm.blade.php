@extends('layout.main')

@section('title')
    افزودن سفارش جدید
@endsection


@section('content')

    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-6">

                <div class="form-group">
                    <label for="name">نام و نام خانوادگی:</label>
                    <input type="text" id="name" class="form-control" name="name"
                           placeholder="نام و نام خانوادگی را وارد کنید">
                </div>

                <div class="form-group">
                    <label for="phone">شماره تماس:</label>
                    <input type="tel" id="phone" class="form-control" name="phone"
                           placeholder="شماره موبایل را وارد کنید">
                </div>

                <div class="form-group">
                    <label for="address">آدرس:</label>
                    <textarea id="address" class="form-control" name="address" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="zip_code">کد پستی:</label>
                    <input type="text" id="zip_code" class="form-control" name="zip_code"
                           placeholder="کد پستی را وارد کنید">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="orders">سفارشات:</label>
                    <textarea id="orders" class="form-control" name="orders" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="desc">توضیحات:</label>
                    <textarea id="desc" class="form-control" name="desc" rows="3"></textarea>
                </div>
                <input type="submit" class="btn btn-success" value="ذخیره">
                <input type="reset" class="btn btn-danger" value="پاک کردن">
            </div>
        </div>
    </form>
@endsection
