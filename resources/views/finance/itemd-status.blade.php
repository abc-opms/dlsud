@extends('forms.itemdisposal_con')
@section('tab')
<div class="tab"><a href="/f/itemdisposal/sign/logs">Transactions</a></div>
<div class="tab current-tab "><a href="/f/itemdisposal/logs">Status</a></div>
@endsection


@section('val')
@livewire('custodian.itemd-status',['id' => $id])
@endsection