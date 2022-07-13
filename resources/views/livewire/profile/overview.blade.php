<h5 class="card-title">Profile Details</h5>

<div class="row">
    <div class="col-sm-3  label ">Full Name</div>
    <div class="col-sm-9 ">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
</div>

<div class="row">
    <div class="col-sm-3 label ">School ID</div>
    <div class="col-sm-9">{{Auth::user()->school_id}}</div>
</div>

<div class="row">
    <div class="col-sm-3 label ">Position</div>
    <div class="col-sm-9">{{Auth::user()->position}}</div>
</div>

<div class="row">
    <div class="col-sm-3 label ">Department</div>
    <div class="col-sm-9">{{$dept}}</div>
</div>

<div class="row">
    <div class="col-sm-3 label ">Sub Department</div>
    <div class="col-sm-9">{{$subdept}}</div>
</div>

<div class="row">
    <div class="col-sm-3 label">Email</div>
    <div class="col-sm-9">{{Auth::user()->email}}</div>
</div>


<div class="row">
    <div class="col-sm-3 label">Siganture</div>
    <img src="/storage/esigs/{{Auth::user()->signature_path}}" alt="esig" class="sigview">
</div>


<style>
    .sigview {
        width: 200px;
    }
</style>