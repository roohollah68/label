@extends('layout.main')

@section('title')
    مدیریت کاربران
@endsection

@section('files')
    <script src="{{mix('js/manage-users.js')}}"></script>
@endsection

@section('content')
    @csrf
    <h3>لیست کاربران تایید نشده:</h3>

    <h3>لیست کاربران تایید شده:</h3>

@endsection
