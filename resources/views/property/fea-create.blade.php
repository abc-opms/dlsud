@extends('forms.fea_con')
@section('tab')
<div class="tab current-tab"><a href="/create/fea/logs">Crete FEA</a></div>
<div class="tab "><a href="/fea/sign/logs">Sign</a></div>
<div class="tab "><a href="/fea/logs">Status</a></div>
@endsection


@section('val')
@livewire('property.feacreate',['id'=>$id])
@endsection