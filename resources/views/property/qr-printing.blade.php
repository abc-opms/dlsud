@extends('forms.qr_con')
@section('tab')
<div class="tab "><a href="/generate/qrretagging/logs">Transactions</a></div>
<div class="tab current-tab "><a href="/qrretagging/printing/logs">Generate</a></div>
<div class="tab "><a href="/qrretagging/logs">Logs</a></div>
@endsection


@section('val')
@livewire('property.qr-printing',['id' => $id])
@endsection