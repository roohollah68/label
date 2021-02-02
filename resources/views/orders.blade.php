@extends('layout.main')

@section('title')
    مشاهده سفارشات
@endsection

@section('files')
    <script src="{{mix('js/orders.js')}}"></script>
@endsection

@section('content')
    <table>
        <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>#</th>
            <th>نام</th>
            <th>سفارش</th>
            <th>توضیحات</th>
            <th>مشاهده</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $counter=>$order)
            <tr>
                <th><input type="checkbox"></th>
                <td>{{$counter + 1}}</td>
                <td>{{$order->name}}</td>
                <td>{{substr($order->orders ,0,40)}} ...</td>
                <td>{{substr($order->desc ,0,40)}} ...</td>
                <td><i>show</i></td>
                <td><i>delete</i> <i>edit</i> <i>pdf</i> </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
