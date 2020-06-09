<div class="sidebar" data-active-color="success">
    <div class="logo">
        <a href="{{ route('home.index') }}" class="simple-text logo-normal">
            <div class="logo-image-big">
                <img src="{{ asset('images/logo.jpg') }}">
            </div>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @if(checkRole('admin') || checkRole('superadmin'))
                <li class="{{ isActive('home') }}{{ isActive('/') }}">
                    <a href="{{ route('home.index') }}">
                        <i class="fa fa-tachometer"></i>
                        <p>หน้าแรก</p>
                    </a>
                </li>
                <li class="{{ isActive('admin/reserving*') }}">
                    <a href="{{ route('admin.reserving.index') }}">
                        <i class="fa fa-list"></i>
                        <p>คำร้องขอ</p>
                    </a>
                </li>
                <li class="{{ isActive('admin/members*') }}">
                    <a href="{{ route('admin.members.index') }}">
                        <i class="fa fa-users"></i>
                        <p>สมาชิก</p>
                    </a>
                </li>
                <li class="{{ isActive('admin/equipments*') }}">
                    <a href="{{ route('admin.equipments.index') }}">
                        <i class="fa fa-wrench"></i>
                        <p>ครุภัณฑ์</p>
                    </a>
                </li>
                <li class="{{ isActive('admin/histories*') }}">
                    <a href="{{ route('admin.histories.index') }}">
                        <i class="fa fa-folder-open"></i>
                        <p>ประวัติ</p>
                    </a>
                </li>
            @elseif(checkRole('user'))
                <li class="{{ isActive('home') }}{{ isActive('/') }}">
                    <a href="{{ route('home.index') }}">
                        <i class="fa fa-tachometer"></i>
                        <p>หน้าแรก</p>
                    </a>
                </li>
                <li class="{{ isActive('reserving*') }}">
                    <a href="{{ route('user.reserving.index') }}">
                        <i class="fa fa-list"></i>
                        <p>คำร้องขอ</p>
                    </a>
                </li>
                <li class="{{ isActive('transfers*') }}">
                    <a href="{{ route('user.transfers.index') }}">
                        <i class="fa fa-exchange"></i>
                        <p>แลกเปลี่ยนครุภัณฑ์</p>
                    </a>
                </li>
                <li class="{{ isActive('equipments*') }}">
                    <a href="{{ route('user.equipments.index') }}">
                        <i class="fa fa-wrench"></i>
                        <p>ครุภัณฑ์</p>
                    </a>
                </li>
                <li class="{{ isActive('histories*') }}">
                    <a href="{{ route('user.histories.index') }}">
                        <i class="fa fa-folder-open"></i>
                        <p>ประวัติ</p>
                    </a>
                </li>
            @elseif(checkRole('engineer'))
                <li class="{{ isActive('home') }}{{ isActive('/') }}">
                    <a href="{{ route('home.index') }}">
                        <i class="fa fa-tachometer"></i>
                        <p>หน้าแรก</p>
                    </a>
                </li>
                <li class="{{ isActive('engineer/tasks*') }}">
                    <a href="{{ route('engineer.tasks.index') }}">
                        <i class="fa fa-list"></i>
                        <p>รายการงาน</p>
                    </a>
                </li>
                <li class="{{ isActive('engineer/histories*') }}">
                    <a href="{{ route('engineer.histories.index') }}">
                        <i class="fa fa-tachometer"></i>
                        <p>ประวัติ</p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
