@extends('forms.rtf_con')
@section('tab')
<div class="tab "><a href="/f/rtf/sign/logs">Transactions</a></div>
<div class="tab  current-tab"><a href="/f/rtf/logs">Status</a></div>
@endsection


@section('val')
@livewire('custodian.rtf-status',['id' => $id])
@endsection