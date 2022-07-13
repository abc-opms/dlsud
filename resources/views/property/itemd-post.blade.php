@extends('forms.itemdisposal_con')
@section('tab')
<div class="tab"><a href="/p/itemdisposal/sign/logs">Transactions</a></div>
<div class="tab current-tab "><a href="/p/itemdisposal/post/logs">Posting</a></div>
<div class="tab  "><a href="/p/itemdisposal/logs">Status</a></div>
@endsection


@section('val')
@livewire('property.itemd-post',['id' => $id])
@endsection