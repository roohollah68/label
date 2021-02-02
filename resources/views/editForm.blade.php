@extends('layout.main')

@section('title')
    ویرایش سفارش
@endsection

@section('files')
    <script src="{{mix('js/addOrder.js')}}"></script>
@endsection

@section('content')
    <script>
        let edit = true
    </script>
    <form action="" method="post">
        @csrf
        <div class="row">
            @foreach([
                ['name' , 'text' , 'نام و نام خانوادگی' , 'input' , 'required',false],
                ['phone' , 'tel' , 'شماره تماس' , 'input', 'required minlength=10 maxlength=11 pattern=\d*',false],
                ['address' , 'text' , 'آدرس' , 'textarea', 'required',true],
                ['zip_code' , 'text' , 'کد پستی' , 'input', 'required minlength=10 maxlength=10 pattern=\d*',false],
                ['orders' , 'text' , 'سفارشات' , 'textarea', 'required',true],
                ['desc' , 'text' , 'توضیحات' , 'textarea', 'required',true],

            ] as $arr)
                <div class="col-md-6">
                    <div class="form-group input-group {{$arr[4]}}">
                        <div class="input-group-append" style="min-width: 160px">
                            <label for="{{$arr[0]}}" class="input-group-text w-100">{{$arr[2]}}:</label>
                        </div>
                        <{{$arr[3]}} type="{{$arr[1]}}" id="{{$arr[0]}}" class="form-control" name="{{$arr[0]}}" rows="2" {{$arr[4]}} value="{{$order[$arr[0]]}}">@if($arr[5]){{$order[$arr[0]]}}</{{$arr[3]}}>@endif
                    </div>
                </div>
        @endforeach
        </div>
        <input type="submit" class="btn btn-success" value="ویرایش">&nbsp;
        <a href="{{route('listOrders')}}" class="btn btn-danger">بازگشت</a>
    </form>
@endsection
