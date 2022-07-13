@extends('forms.rtf_con')
@section('tab')
<div class="tab current-tab"><a href="/rtf/sign/logs">Transactions</a></div>
<div class="tab  "><a href="/rtf/post/logs">Posting</a></div>
<div class="tab "><a href="/rtf/logs">Status</a></div>
@endsection


@section('val')
@livewire('property.rtf-sign',['id' => $id])
@endsection