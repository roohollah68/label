@extends('layout.main')

@section('title')
    ویرایش سفارش
@endsection

@section('files')

@endsection

@section('content')
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @foreach([
                ['name' , 'text' , 'نام و نام خانوادگی' , 'input' , 'required'],
                ['phone' , 'tel' , 'شماره تماس' , 'input', 'required minlength=11 maxlength=11 pattern=\d*'],
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
                        @if($arr[3] == 'input')
                            <input value="{{$order[$arr[0]]}}" type="{{$arr[1]}}" id="{{$arr[0]}}" class="form-control"
                                   name="{{$arr[0]}}" {{$arr[4]}}>
                        @else
                            <textarea name="{{$arr[0]}}" id="{{$arr[0]}}" class="form-control"
                                      rows="2" {{$arr[4]}}>{{$order[$arr[0]]}}</textarea>
                        @endif
                    </div>
                </div>
            @endforeach
                <div class="col-md-6">
                    <div class="form-group input-group ">
                        <div class="input-group-append" style="width: 160px">
                            <label for="receipt" class="input-group-text w-100">تصویر رسید بانکی:</label>
                        </div>
                        <input type="file" id="receipt" class="" name="receipt">
                    </div>
                </div>
        </div>
        @if($order->receipt)
            <a href="/receipt/{{$order->receipt}}" target="_blank"><img style="width: 300px" src="/receipt/{{$order->receipt}}"></a>
        @endif
        <br>
        <br>
        <input type="submit" class="btn btn-success" value="ویرایش">&nbsp;
        <a href="{{route('listOrders')}}" class="btn btn-danger">بازگشت</a>
    </form>
@endsection
