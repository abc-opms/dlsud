@extends('forms.itemdisposal_con')
@section('tab')
<div class="tab current-tab"><a href="/b/itemdisposal/logs">Transaction</a></div>
@endsection


@section('val')
@livewire('custodian.itemd-status',['id' => $id])
@endsection