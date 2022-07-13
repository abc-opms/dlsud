@extends('forms.itemdisposal_con')
@section('tab')
<div class="tab current-tab "><a href="/itemdisposal/sign/logs">Transactions</a></div>
<div class="tab "><a href="/itemdisposal/logs">Status</a></div>
@endsection


@section('val')
@livewire('warehouse.itemd-sign',['id' => $id])
@endsection