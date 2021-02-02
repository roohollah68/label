@extends('layout.main')

@section('title')
    افزودن سفارش جدید
@endsection

@section('files')
    <script src="{{mix('js/addOrder.js')}}"></script>
@endsection

@section('content')

    <form action="" method="post">
        @csrf
        <div class="row">
            @foreach([
                ['name' , 'text' , 'نام و نام خانوادگی' , 'input' , 'required'],
                ['phone' , 'tel' , 'شماره تماس' , 'input', 'required minlength=10 maxlength=11 pattern=\d*'],
                ['address' , 'text' , 'آدرس' , 'textarea', 'required'],
                ['zip_code' , 'text' , 'کد پستی' , 'input', 'required minlength=10 maxlength=10 pattern=\d*'],
                ['orders' , 'text' , 'سفارشات' , 'textarea', 'required'],
                ['desc' , 'text' , 'توضیحات' , 'textarea', 'required'],

            ] as $arr)
                <div class="col-md-6">
                    <div class="form-group input-group {{$arr[4]}}">
                        <div class="input-group-append" style="min-width: 160px">
                            <label for="{{$arr[0]}}" class="input-group-text w-100">{{$arr[2]}}:</label>
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
