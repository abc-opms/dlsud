<div>
    <div class="mt-4 card p-3">
        <!--CREATE NEW-->

        <div class="row d-flex justify-content-end mb-3">
            <div class="col-sm-6">
                <select class="mt-1 entries bg-light" wire:model="entries">
                    <option selected value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <label for="">entries per page</label>
            </div>

            <div class="col-sm-6 d-flex justify-content-end">
                <div class="d-flex">
                    @if($filterby == 'role')
                    <select class="form-select filter-record mt-1" wire:model="role_type">
                        <option value="Custodian">Custodian</option>
                        <option value="Property">Property</option>
                        <option value="Finance">Finance</option>
                        <option value="Warehouse">Warehouse</option>
                        <option value="BFMO">BFMO</option>
                        <option value="ICTC">ICTC</option>
                    </select>
                    @else
                    <x-jet-input placeholder="Search..." id="search" class="block mt-1 w-full search-record" type="search " wire:model="search" />
                    @endif
                    <select class="form-select filter-record mt-1" wire:model="filterby">
                        <option value="dept_code">Dept. code</option>
                        <option value="subdept_code">Subept. code</option>
                        <option value="role">Role</option>
                        <option value="status">Status</option>
                        <option value="school_id">School ID</option>
                        <option value="email">Email</option>
                    </select>
                </div>
            </div>
        </div>




        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head">
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">School ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Position</th>
                        <th scope="col">Dept Code</th>
                        <th scope="col">SubDept Code</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($user))
                    @for($i =0; $i <= (count($user)-1); $i++) <tr class="record" wire:click="show({{$user[$i]->id}},{{$i}})">
                        <td>{{$user[$i]->first_name}}</td>
                        <td>{{$user[$i]->last_name}}</td>
                        <td>{{$user[$i]->school_id}}</td>
                        <td>{{$user[$i]->position}}</td>
                        <td>{{$user[$i]->email}}</td>
                        <td>{{$user[$i]->dept_code}}</td>
                        <td>{{$user[$i]->subdept_code}}</td>
                        </tr>
                        @endfor
                        @endif
                </tbody>
            </table>
            {{$user->links()}}
        </div>


        @if(empty($user))
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewCustodian" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header-->
                <div class="modal-header bg-modalheader">
                    <h5 class="modal-title h5">User<strong></strong> </h5>
                    <button class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Form-->
                <div class="modal-body">
                    <div class="row pe-3 ps-3 pb-3">

                        <!-- First Name -->
                        <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="first_name" disabled type="text" class="mt-1 block w-full" wire:model.defer="first_name" />
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="last_name" disabled type="text" class="mt-1 block w-full" wire:model.defer="last_name" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Position</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="position" disabled type="text" class="mt-1 block w-full" wire:model.defer="position" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Department</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="dept_code" disabled type="text" class="mt-1 block w-full" wire:model.defer="dept_code" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="email" type="email" disabled class="mt-1 block w-full" wire:model.defer="email" />
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Modal Buttons-->
                <div class="modal-footer ">
                    <button class="btn btn-secondary mt-2 me-3" wire:click="closeModal">Cancel</button>
                </div>
            </div>
        </div>
    </div><!-- End  Modal-->


</div><!-- End -->