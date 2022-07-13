@extends('forms.qr_con')
@section('tab')
<div class="tab  "><a href="/gerenate/reports">Transactions</a></div>
<div class="tab current-tab"><a href="/reports/logs">Logs</a></div>
@endsection


@section('val')
@livewire('property.report-logs')
@endsection