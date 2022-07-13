@extends('forms.inventory_con')
@section('tab')
<div class="tab current-tab"><a href="/create/inventories">Create</a></div>
<div class="tab"><a href="/inventories/monitor/logs">Transactions</a></div>
<div class="tab  "><a href="/inventories/logs">Logs</a></div>

@endsection


@section('val')
@livewire('property.inv-create')
@endsection