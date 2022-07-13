@extends('forms.inventory_con')
@section('tab')
<div class="tab "><a href="/c/inventories/logs">Transaction</a></div>
@endsection


@section('val')
@livewire('custodian.inv-trans')
@endsection