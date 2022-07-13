@extends('forms.fea_con')
@section('tab')
<div class="tab"><a href="/create/fea/logs">Crete FEA</a></div>
<div class="tab current-tab"><a href="/fea/sign/logs">Sign</a></div>
<div class="tab "><a href="/fea/logs">Status</a></div>
@endsection


@section('val')

<!--Property-->
@if(Auth::user()->hasRole('Property'))
@livewire('property.fea-trans',['id'=> $id])
@endif



@endsection