@extends('forms.receivingreport_con')
@section('tab')
<div class="tab current-tab"><a href="/receivingreport/sign/logs">Transactions</a></div>
<div class="tab"><a href="/receivingreport/logs">Status</a></div>
@endsection


@section('val')
@livewire('warehouse.rr-form')
@endsection