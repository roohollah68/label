<ul class="nav">
    <li class="nav-item">
        <a class="nav-item nav-link" href="{{route('newOrder')}}">ایجاد سفارش</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link" href="{{route('listOrders')}}">مشاهده سفارشات</a>
    </li>
    @if($admin)
        <li class="nav-item">
            <a class="nav-item nav-link" href="{{route('manageUsers')}}">مدیریت کاربران</a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-item nav-link" href="{{route('editUser')}}">ویرایش حساب کاربری</a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-item nav-link" href="{{route('logout')}}">خروج</a>
    </li>
</ul>
