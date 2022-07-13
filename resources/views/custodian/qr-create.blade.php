@extends('forms.qr_con')
@section('tab')
<div class="tab current-tab "><a href="/c/qrretagging/logs">Transactions</a></div>
@endsection


@section('val')
@livewire('custodian.qr-create')
@endsection