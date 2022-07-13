@extends('forms.itemdisposal_con')
@section('tab')
<div class="tab current-tab"><a href="/create/itemdisposal">Create</a></div>
<div class="tab "><a href="/c/itemdisposal/logs">Status</a></div>
@endsection


@section('val')
@livewire('custodian.itemd-create')
@endsection