@extends('forms.mainf')

@section('title', 'Receiving Reports')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/receivingreports">Receiving reports</a></li>
@endsection


@section('content')
<div class="page-tab d-flex align-items-center max-filter">
    <div class="tab current-tab">Transactions</div>
    <div class="tab ">Status</div>
</div>
<div class="page-content">
    @livewire('custodian.rrstatus')
</div>




<style type="text/css">
    .page-tab {
        background-color: white;
        height: 55px;
        border-top: 3px solid green;
        border-bottom: 3px solid green;
    }

    .tab {
        width: 150px;
        margin-left: 20px;
    }

    .current-tab {
        font-weight: 600;
        text-decoration: underline;
        color: green;
    }

    .page-content {
        background-color: white;
        height: 500px;
    }
</style>

@endsection