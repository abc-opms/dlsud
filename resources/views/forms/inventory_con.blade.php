@extends('forms.mainf')

@section('title', 'Inventories')

@section('breadcrumb')
<li class="breadcrumb-item">Inventories</li>
@endsection


@section('content')
<div class="page-tab d-flex align-items-center max-filter">
    @yield('tab')
</div>
<div class="">
    @yield('val')
</div>

@endsection