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
    <label for="deleted_orders">مشاهده سفارشات حذف شده</label><input type="checkbox" id="deleted_orders"
                                                                     onclick="prepare_data()">
    <br>
    @if($admin)
    <label for="user">سفیر:</label><select id="user" onchange="prepare_data()">
    </select>
    <label for="website">فروشگاه:</label><select id="website" onchange="prepare_data()">
        <option value="all" selected>همه</option>
        <option value="matchano">matchano.ir</option>
        <option value="berryno">berryno.ir</option>
        <option value="noveltea">noveltea.ir</option>
        <option value="dorateashop">dorateashop.ir</option>
    </select>
    @endif
    <table class="stripe">
    </table>
    @include('layout.command')

@endsection
