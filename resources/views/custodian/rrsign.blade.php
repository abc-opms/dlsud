@extends('forms.receivingreport_con')
@section('tab')
<div class="tab current-tab"><a href="/c/receivingreport/logs">Transactions</a></div>
<div class="tab"><a href="/c/receivingreport/logs">Status</a></div>
@endsection


@section('val')
@livewire('custodian.rrsign',['id' => $id])
@endsection