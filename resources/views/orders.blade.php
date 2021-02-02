@extends('layout.main')

@section('title')
    مشاهده سفارشات
@endsection

@section('files')
    <script src="{{mix('js/orders.js')}}"></script>
    <script src="{{mix('js/html2pdf.bundle.min.js')}}"></script>
@endsection

@section('content')
    @csrf
<label for="deleted_orders">مشاهده سفارشات حذف شده</label><input type="checkbox" id="deleted_orders"  onclick="deleted = this.checked ; get_data()">
    <br>
    @include('layout.command')
    <table>
    </table>
    @include('layout.command')

@endsection
