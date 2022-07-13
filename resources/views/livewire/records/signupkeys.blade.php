<div>
    <div class="mt-4 card p-3">
        <!--CREATE NEW-->
        <div class="col-sm-4  mb-3">
            <button wire:click="createnew" class="btn btn-secondary create-new "><i class="bi bi-plus-circle"></i> Create new</button>
        </div>
        <div class="row d-flex justify-content-between mb-3">
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
                <x-jet-input placeholder="Search..." id="search" class="block mt-1 w-full search-record" type="search " wire:model="search" />
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


        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head ">
                        <th scope="col">School ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Dept Code</th>
                        <th scope="col">SubDept Code</th>
                        <th scope="col">Role</th>
                        <th scope="col">Signupkey</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($signupkeys as $key)
                    <tr wire:click="show('{{$key->id}}')">
                        <td>{{$key->school_id}}</td>
                        <td>{{$key->email}}</td>
                        <td>{{$key->dept_code}}</td>
                        <td>{{$key->subdept_code}}</td>
                        <td>{{$key->role}}</td>
                        <td>{{$key->skey}}</td>
                        @if($key->status == "Active" || $key->status == "active")
                        <td><span class="badge bg-success">{{$key->status}}</span></td>
                        @else
                        <td><span class="badge bg-warning">{{$key->status}}</span></td>
                        @endif
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
        @if(!empty($signupkeys))
        {{$signupkeys->links()}}
        @endif



        @if(empty($signupkeys))
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <script>
        window.addEventListener('showSkey', event => {
            $('#viewSkey').modal('show');
        });

        window.addEventListener('hideSkey', event => {
            $('#viewSkey').modal('hide');
        });
    </script>


    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewSkey" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header-->
                <div class="modal-header bg-modalheader">

                    <h3 class="modal-title"><strong>Signup key</strong> </h3>
                    <button class="btn-close text-light" wire:click="closeModal" aria-label="Close"></button>
                </div>

                <!-- Modal Form-->
                <div class="modal-body">
                    <div class="row pe-3 ps-3 pb-3">

                        <!--- USER ID -->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="school_id" value="School ID" />
                            <x-jet-input id="school_id" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="school_id" />
                            @error('school_id')<span class="error fsize">{{$message}}</span> @enderror
                        </div>

                        <!--- EMAIL -->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="email" />
                            @error('email')<span class="error fsize">{{$message}}</span> @enderror
                        </div>

                        <style>
                            .fsize {
                                font-size: 12px;
                                color: red;
                                font-weight: 500;
                            }
                        </style>

                        <!--- DEPARTMENT ID -->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="department_id" value="{{ __('Department') }}" />
                            <div class="d-flex">
                                <select class="form-select" aria-label="State" wire:model="dept_code">
                                    <option value="" selected>--Select--</option>
                                    @foreach($deptval as $department)
                                    <option value="{{$department->dept_code}}">{{$department->description}}</option>
                                    @endforeach
                                </select>
                                @error('dept_code')<span class="error fsize">*</span> @enderror
                            </div>
                        </div>

                        <!--- SUB DEPARTMENT ID -->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="department_id" value="{{ __('Sub Department') }}" />
                            <div class="d-flex">
                                <select class="form-select" aria-label="State" wire:model="subdept_code">
                                    <option value="" selected>--Select--</option>
                                    @if(!empty($subdeptval))
                                    @foreach($subdeptval as $sb)
                                    <option value="{{$sb->subdept_code}}">{{$sb->description}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('subdept_code')<span class="error fsize">*</span> @enderror
                            </div>
                        </div>

                        <!--- ROLE -->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="role" value="{{ __('Role') }}" />
                            <div class="d-flex">
                                <select class="form-select" aria-label="State" wire:model="role">
                                    <option value="" selected>--Select--</option>
                                    <option value="Custodian">Custodian</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Warehouse">Warehouse</option>
                                    <option value="BFMO">BFMO</option>
                                    <option value="ICTC">ICTC</option>
                                </select>
                                @error('role')<span class="error fsize">*</span> @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Modal Buttons-->
                    <div class="modal-footer ">
                        <button class="btn btn-secondary mt-2 me-3" wire:click="closeModal">Cancel</button>
                        @if(!empty($updateID))
                        <button class="btn btn-success mt-2 me-3" wire:click="updateSkey">{{__('Update')}}</button>
                        @else
                        <button class="btn btn-success mt-2 me-3" wire:click="saveSkey">{{__('Save')}}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- End  Modal-->


    </div>