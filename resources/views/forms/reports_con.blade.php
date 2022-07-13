@extends('forms.mainf')

@section('title', 'Reports')

@section('breadcrumb')
<li class="breadcrumb-item">reports</li>
@endsection


@section('content')
<div class="page-tab d-flex align-items-center max-filter">
    @yield('tab')
</div>
<div class="page-content">
    @yield('val')
</div>
@endsection