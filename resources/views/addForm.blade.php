@extends('layout.main')

@section('title')
    افزودن سفارش جدید
@endsection


@section('content')

    <form action="" method="post">
        @csrf
        <div class="row">
            @foreach([
                ['name' , 'text' , 'نام و نام خانوادگی' , 'input' , 'required'],
                ['phone' , 'tel' , 'شماره تماس' , 'input', ''],
                ['address' , 'text' , 'آدرس' , 'textarea', 'required'],
                ['zip_code' , 'text' , 'کد پستی' , 'input', ''],
                ['orders' , 'text' , 'سفارشات' , 'textarea', 'required'],
                ['desc' , 'text' , 'توضیحات' , 'textarea', ''],

            ] as $arr)
                <div class="col-md-6">
                    <div class="form-group input-group {{$arr[4]}}">
                        <div class="input-group-append">
                            <label for="{{$arr[0]}}" class="input-group-text">{{$arr[2]}}:</label>
                        </div>
                        <{{$arr[3]}} type="{{$arr[1]}}" id="{{$arr[0]}}" class="form-control" name="{{$arr[0]}}" rows="2" {{$arr[4]}}></{{$arr[3]}}>
{{--                        <div class="input-group-prepend">--}}
{{--                            <span class="btn btn-outline-secondary fa fa-paste" onclick="$('#{{$arr[0]}}').val(await navigator.clipboard.readText())"></span>--}}
{{--                        </div>--}}
                    </div>
                </div>
        @endforeach
        </div>
        <input type="submit" class="btn btn-success" value="ذخیره">&nbsp;
        <input type="reset" class="btn btn-danger" value="پاک کردن">


    </form>
@endsection
