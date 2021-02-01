@extends('layout.main')

@section('title')
    افزودن سفارش جدید
@endsection


@section('content')
    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label>نام و نام خانوادگی:</label>
            <input type="text" name="name" placeholder="نام و نام خانوادگی را وارد کنید">
        </div>

        <div class="form-group">
            <label>شماره تماس:</label>
            <input type="tel" name="phone" placeholder="شماره موبایل را وارد کنید">
        </div>

        <div class="form-group">
            <label>آدرس:</label>
            <textarea name="address" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>کد پستی:</label>
            <input type="text" name="zip_code" placeholder="کد پستی را وارد کنید">
        </div>

        <div class="form-group">
            <label>سفارشات:</label>
            <textarea name="orders" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>توضیحات:</label>
            <textarea name="desc" rows="3"></textarea>
        </div>
        <input type="submit" value="submit">

    </form>
@endsection
