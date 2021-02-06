@extends('layout.main')

@section('title')
    ویرایش کاربر
@endsection

@section('files')

@endsection

@section('content')
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group input-group">
                    <div class="input-group-append" style="min-width: 160px">
                        <label for="name" class="input-group-text w-100">نام و نام خانوادگی:</label>
                    </div>
                    <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group input-group">
                    <div class="input-group-append" style="min-width: 160px">
                        <label for="username" class="input-group-text w-100">نام کاربری:</label>
                    </div>
                    <input type="text" id="username" class="form-control" name="username" minlength="5"
                           value="{{$user->username}}" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group input-group">
                    <div class="input-group-append" style="min-width: 160px">
                        <label for="phone" class="input-group-text w-100">شماره تماس:</label>
                    </div>
                    <input type="text" id="phone" class="form-control" name="phone" minlength="11" maxlength="11"
                           pattern="\d*" value="{{$user->phone}}" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group input-group">
                    <div class="input-group-append" style="min-width: 160px">
                        <label for="website" class="input-group-text w-100">فروشگاه:</label>
                    </div>
                    <select class="form-control" id="website" name="website">
                        @foreach(["matchano","berryno","noveltea","dorateashop"] as $shop)
                            <option value="{{$shop}}" @if($shop == $user->website) selected @endif >{{$shop}}.ir
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group input-group">
                    <div class="input-group-append" style="min-width: 160px">
                        <label for="password" class="input-group-text w-100">رمز عبور:</label>
                    </div>
                    <input type="text" id="password" class="form-control" name="password" value="" placeholder="همان رمز عبور قبلی" >
                </div>
            </div>

        </div>
        <input type="submit" class="btn btn-success" value="ویرایش">&nbsp;
        <a href="{{route('manageUsers')}}" class="btn btn-danger">بازگشت</a>
    </form>
@endsection
