<div>
    <div class="mt-4 card p-3">
        <!--CREATE NEW-->
        @if(Auth::user()->hasRole('Property'))
        <div class="col-sm-4  mb-3">
            <button wire:click="createnew" class="btn btn-secondary create-new "><i class="bi bi-plus-circle"></i> Create new</button>
        </div>
        @endif
        <div class="row d-flex justify-content-between mb-3">

            <div class="col-sm-6">
                <select class="mt-1 entries bg-light" wire:model="entries">
                    <option selected value="40">40</option>
                    <option value="80">80</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                </select>
                <label for="">entries per page</label>
            </div>

            <div class="col-sm-6 d-flex justify-content-end">
                <x-jet-input placeholder="Search..." id="search" class="block mt-1 w-full search-record" type="search " wire:model="search" />
                <select class="form-select filter-record mt-1" wire:model="filterby">
                    <option selected value="dept_code">Dept Code</option>
                    <option value="description">Description</option>
                    <option value="fund_code">Fund Code</option>
                </select>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head ">
                        <th scope="col">Department Code</th>
                        <th scope="col">Description</th>
                        <th scope="col">Fund Code</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($dept))
                    @for($i =0; $i <= (count($dept)-1); $i++) <tr class="record" wire:click="show({{$dept[$i]->id}},{{$i}})">
                        <td>{{$dept[$i]->dept_code}}</td>
                        <td>{{$dept[$i]->description}}</td>
                        <td>{{$dept[$i]->fund_code}}</td>
                        </tr>
                        @endfor
                        @endif
                </tbody>
            </table>
        </div>
        {{$dept->links()}}

        @if(empty($dept))
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewDepartment" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header-->
                <div class="modal-header bg-modalheader">
                    @if(!empty($updateID))
                    <h5 class="modal-title h5"><strong> Department</strong> </h5>
                    @else
                    <h3 class="modal-title h4"><strong>Create new Supplier</strong> </h3>
                    @endif
                    <button class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Form-->
                <div class="modal-body">
                    <div class="row pe-3 ps-3 pb-3">

                        <!---dept_code-->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="dept_code" value="Department Code" />
                            <div class="d-flex">
                                <input id="dept_code" class="r-field block mt-1 w-full @if(!Auth::user()->hasRole('Property')) record-f-disabled @endif" type="text" wire:model="dept_code" />
                                @error('dept_code')<span class="error text-danger">*</span> @enderror
                            </div>
                        </div>

                        <!--- fund_code-->
                        <div class="col-md-6 mt-3">
                            <x-jet-label for="fund_code" value="Fund Code" />
                            <div class="d-flex">
                                <input id="fund_code" class="r-field block mt-1 w-full @if(!Auth::user()->hasRole('Property')) record-f-disabled @endif" type="text" wire:model="fund_code" />
                                @error('fund_code')<span class="error text-danger">*</span> @enderror
                            </div>
                        </div>

                        <!--- Address -->
                        <div class="col-md-12 mt-3">
                            <x-jet-label for="description" value="Description" />
                            <div class="d-flex">
                                <textarea id="description" rows="4" class="border block mt-1 w-full @if(!Auth::user()->hasRole('Property')) record-f-disabled @endif" style="border:none; border-radius: 5px;" wire:model="description"></textarea>
                                @error('description')<span class="error text-danger ">*</span> @enderror
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Modal Buttons-->
                <div class="modal-footer ">
                    <button class="btn btn-secondary mt-2 me-3" wire:click="closeModal">Cancel</button>
                    @if(Auth::user()->hasRole('Property'))
                    @if(!empty($updateID))
                    <button class="btn btn-success mt-2 me-3" wire:click="updateSupplier">{{__('Update')}}</button>
                    @else
                    <button class="btn btn-success mt-2 me-3" wire:click="saveSupplier">{{__('Save')}}</button>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div><!-- End  Modal-->




</div><!-- End -->