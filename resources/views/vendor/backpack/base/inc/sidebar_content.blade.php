<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('demo') }}'>
        <i class='nav-icon la la-question'></i> Demos
    </a>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" data-toggle="collapse">
        <i class="la la-star nav-icon"></i>&nbsp;{{__('Plantillas')}}
    </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'>
            <a class='nav-link' href='{{ route('templates.base.crud') }}'>
                <i class='nav-icon la la-table'></i>&nbsp;{{__('Base Crud')}}
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ route('templates.plain.database.crud') }}'>
                <i class='nav-icon la la-table'></i>&nbsp;{{__('Plain Database')}}
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ route('templates.plain.form.content.crud') }}'>
                <i class='nav-icon la la-table'></i>&nbsp;{{__('Plain Form Content')}}
            </a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ route('templates.plain.database.advanced') }}'>
                <i class='nav-icon la la-table'></i>&nbsp;{{__('Plain Database Advanced')}}
            </a>
        </li>
    </ul>
</li>