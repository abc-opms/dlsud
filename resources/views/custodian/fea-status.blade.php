@extends('forms.fea_con')
@section('tab')
<div class="tab "><a href="/c/fea/sign/logs">Transactions</a></div>
<div class="tab current-tab"><a href="/c/fea/logs">Status</a></div>
@endsection


@section('val')
@livewire('property.feastatus',['id' => $id])
@endsection