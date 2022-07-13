@extends('forms.rtf_con')
@section('tab')
<div class="tab "><a href="/c/rtf/sign/logs">Transactions</a></div>
<div class="tab  current-tab"><a href="/c/rtf/logs">Status</a></div>
<div class="tab"><a href="/rtf/received/logs">Receiving Status</a></div>
@endsection


@section('val')
@livewire('custodian.rtf-status',['id' => $id])
@endsection