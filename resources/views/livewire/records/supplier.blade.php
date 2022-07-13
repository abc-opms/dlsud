<div>
    <div class="mt-4 card p-3">
        <!--CREATE NEW-->
        <div class="row d-flex justify-content-between mb-3">
            <div class="col-sm-4  mb-3">
                @if(Auth::user()->hasRole('Warehouse'))
                <button wire:click="createnew" class="btn btn-secondary create-new "><i class="bi bi-plus-circle"></i> Create new</button>
                @endif
            </div>

            <div class="col-sm-8 d-flex justify-content-end">
                <x-jet-input placeholder="Search..." id="search" class="block mt-1 w-full search-record" type="search " wire:model="search" />
                <select class="form-select filter-record mt-1" wire:model="filterby">
                    <option selected value="name">Name</option>
                    <option value="address">Address</option>
                </select>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head ">
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Tel No.</th>
                        <th scope="col">Fax No.</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($suppliers))
                    @for($i =0; $i <= (count($suppliers)-1); $i++) <tr class="record" wire:click="show({{$suppliers[$i]->id}},{{$i}})">
                        <td>{{$suppliers[$i]->name}}</td>
                        <td>{{$suppliers[$i]->address}}</td>
                        <td>{{$suppliers[$i]->telnum}}
                            @if(!empty($suppliers[$i]->telnum_al))
                            / {{$suppliers[$i]->telnum_al}}
                            @endif </td>
                        <td>{{$suppliers[$i]->faxnum}}
                            @if(!empty($suppliers[$i]->faxnum_al))
                            {{$suppliers[$i]->faxnum_al}}
                            @endif
                        </td>
                        </tr>
                        @endfor
                        @endif
                </tbody>
            </table>
        </div>
        {{$suppliers->links()}}

        @if(empty($suppliers))
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewSupplier" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header-->
                <div class="modal-header bg-modalheader">
                    @if(!empty($updateID))
                    <h5 class="modal-title h5">Supplier code #<strong>{{$supplier_code}}</strong> </h5>
                    @else
                    <h3 class="modal-title h4"><strong>Create new Supplier</strong> </h3>
                    @endif
                    <button class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Form-->
                <div class="modal-body">
                    <div class="row pe-3 ps-3 pb-3">

                        <!--- Name -->
                        <div class="col-md-12 mt-3">
                            <x-jet-label for="name" value="Name" />
                            <div class="d-flex">
                                <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="name" />
                                @error('name')<span class="error text-danger">*</span> @enderror
                            </div>
                        </div>

                        <!--- Address -->
                        <div class="col-md-12 mt-3">
                            <x-jet-label for="address" value="Address" />
                            <div class="d-flex">
                                <textarea id="address" rows="4" class="border block mt-1 w-full" style="border:none; border-radius: 5px;" wire:model.debounce.800ms="address"></textarea>
                                @error('address')<span class="error text-danger ">*</span> @enderror
                            </div>
                        </div>

                        <!--- Telnum -->
                        <div class="col-md-12 mt-3">
                            <x-jet-label for="telnum" value="Tel no." />
                            <div class="d-flex">
                                <div class="col-md-6 me-2">
                                    <div class="d-flex">
                                        <x-jet-input id="telnum" class="block mt-1 w-full" type="tel" wire:model.debounce.800ms="telnum" />
                                        @error('telnum')<span class="error text-danger ">*</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <x-jet-input id="telnum2" class="block mt-1 w-full" type="tel" wire:model.debounce.800ms="telnum2" />
                                        @error('telnum2')<span class="error text-danger ">*</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- faxnum -->
                        <div class="col-md-12 mt-3">
                            <x-jet-label for="faxnum" value="Fax no." />
                            <div class="d-flex">
                                <div class="col-md-6 me-2">
                                    <div class="d-flex">
                                        <x-jet-input id="faxnum" class="block mt-1 w-full" type="tel" wire:model.debounce.800ms="faxnum" />
                                        @error('faxnum')<span class="error text-danger ">*</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <x-jet-input id="faxnum2" class="block mt-1 w-full" type="tel" wire:model.debounce.800ms="faxnum2" />
                                        @error('faxnum2')<span class="error text-danger ">*</span> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal Buttons-->
                <div class="modal-footer ">
                    <button class="btn btn-secondary mt-2 me-3" wire:click="closeModal">Cancel</button>
                    @if(!empty($updateID))
                    <button class="btn btn-success mt-2 me-3" wire:click="updateSupplier">{{__('Update')}}</button>
                    @else
                    <button class="btn btn-success mt-2 me-3" wire:click="saveSupplier">{{__('Save')}}</button>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- End  Modal-->


</div><!-- End -->