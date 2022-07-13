@extends('forms.itemdisposal_con')
@section('tab')
<div class="tab current-tab"><a href="/f/itemdisposal/sign/logs">Transactions</a></div>
<div class="tab  "><a href="/f/itemdisposal/logs">Status</a></div>
@endsection


@section('val')
@livewire('finance.itemd-sign',['id' => $id])
@endsection