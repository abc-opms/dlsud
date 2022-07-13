@extends('forms.reports_con')
@section('tab')
<div class="tab current-tab "><a href="/gerenate/reports">Transactions</a></div>
<div class="tab "><a href="/reports/logs">Logs</a></div>
@endsection


@section('val')
@livewire('property.reports-create')
@endsection