<div>
    @if(Session::has('download.in.the.next.request'))
    <meta http-equiv="refresh" content="5;url={{ Session::get('download.in.the.next.request') }}">
    @endif
    <div class="row bg-white">

        <div class="col-md-3 bg-white  border">
            <div class="bg-light-gy p-3 border max-filter ">
                <div>
                    <x-jet-label for="skey" class="h2" value="Search RQR No." />
                    <x-jet-input wire:model="search" id="search" class="block mt-1 w-full" type="search" />
                </div>
            </div>


            <!--FEA Numbers-->
            <div class="overflow-auto list-number bg-white max-filter p-2">

                <ul class="nav-parent list-group list-group-flush">
                    <ul class="num-list nav-parent list-group list-group-flush">
                        @forelse($rqr as $val)
                        <li id="{{$val->rqr_number}}" wire:click="openForm('{{$val->rqr_number}}')" class="list-group-item d-flex justify-content-between align-items-center">
                            RQR {{$val->rqr_number}}

                            @if(empty($val->read_at))
                            <span class="badge  rounded-pill text-white p-1" style="background-color: #408AE8;">
                                <i class="bi bi-star-fill"></i> New
                            </span>
                            @endif
                        </li>
                        @empty
                        <p class="text-center">No data available</p>
                        @endforelse
                    </ul>
            </div>
        </div>


        <div class="col-md-9 min-height-form" id="form-content">
            @if(empty($rqr_number))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>


            <!--FORM-->
            @else
            <div>
                <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
                    <h5 class="mt-1">General Information</h5>
                    <button class="btn btn-sm btn-secondary" wire:click="clear" wire:loading.attr="disabled">
                        {{ __('x') }}
                    </button>
                </div>

                <div class="d-flex mt-2 mb-3 justify-content-end">
                    <div wire:loading wire:target="saveQR" class="mt-2">
                        Saving...
                    </div>
                    <x-jet-button wire:click="saveQR" wire:loading.attr="disabled" class="bg-success ms-3">
                        Save
                    </x-jet-button>
                </div>


                <div class="p-1">
                    <h6 class="mt-1">Requesting Department</h6>
                </div>

                <div class="col-md-12 bg-white p-2">
                    <!-- HEADER DETAILS -->
                    <div class="row">
                        <div class="col-md-6 mt-1">
                            <table style="width: 95%;">
                                <tr>
                                    <td>Name:df</td>
                                    <td>
                                        <input wire:model="name" class="inpur-underline block mt-1 w-full">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reason:</td>
                                    <td>
                                        <input disabled wire:model="reason" class="inpur-underline block mt-1 w-full">
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-6 mt-3">
                            <table style="width: 90%;">
                                <tr>
                                    <td>Dept./Unit:</td>
                                    <td>
                                        <input disabled wire:model="dept" class="inpur-underline block mt-1 w-full">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td>
                                        <input disabled wire:model="date" class="inpur-underline block mt-1 w-full">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ITEMS -->
                <div class="bg-dark-gy mt-3 max-form d-flex align-items-center justify-content-between p-2">
                    <label>Item table</label>
                </div>
                <div>
                    <div class="row">
                        <!--Items Table-->
                        <div id="itemtable" class="mt-1">
                            <div class="col-md-12 overflow-auto" style="max-height: 500px;">
                                <div class="col-md-12 table-responsive p-1">
                                    <table class="table table-hover table-bordered">
                                        <thead class="text-center">
                                            <tr class="">
                                                <th scope="col">Qty</th>
                                                <th scope="col">Oum</th>
                                                <th scope="col">item/Description</th>
                                                <th scope="col">Serial No.</th>
                                                <th scope="col">property No.</th>
                                                <th scope="col">Acq. Date</th>
                                                <th scope="col">Fea No.</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @for($i=0; $i< count($ItemArray);$i++) <tr>
                                                <td>1</td>
                                                <td>{{$ItemArray[$i]->oum}}</td>
                                                <td>{{$ItemArray[$i]->item}}</td>
                                                <td>
                                                    @if(!empty($ItemArray[$i]->serial_number))
                                                    {{$ItemArray[$i]->serial_number}}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>{{$ItemArray[$i]->property_number}}</td>
                                                <td>{{$ItemArray[$i]->acq_date}}</td>
                                                <td>
                                                    {{$ItemArray[$i]->fea_number}}
                                                </td>
                                                <td>
                                                    @if(!empty($ItemArray[$i]->item_status))
                                                    {{$ItemArray[$i]->item_status}}

                                                    <button class="btn btn-sm  bg-warning" wire:click="showEdit('{{$ItemArray[$i]->property_number}}', {{$i}})" wire:loading.attr="disabled">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    @else
                                                    <button wire:click="showHistory('{{$ItemArray[$i]->property_number}}', {{$i}})" wire:loading.attr="disabled" class="btn btn-sm bg-success text-light">
                                                        Add
                                                    </button>
                                                    @endif
                                                </td>

                                                </tr>
                                                @endfor


                                        </tbody>
                                    </table>

                                    @if(empty($ItemArray))
                                    <div class="text-center">
                                        <label for=""> No Item Available</label>
                                    </div>
                                    @endif
                                    <!-- End Table-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endif
        </div>


        <div wire:ignore.self class="modal fade" id="modalHistory" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Item Qr tagging History</h5>
                        Property No.: {{$property}}
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="d-flex justify-content-center">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <td>Date Requested</td>
                                        <td>Reason</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($historyItems))
                                    @forelse($historyItems as $h)
                                    <tr>
                                        <td>{{$h->req_date}}</td>
                                        <td>{{$h->reason}}</td>
                                        <td>{{$h->item_status}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="p-2 text-center">
                                                No QR tagging history
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <label for="">Action</label>
                            <div class="d-flex">
                                <select wire:model="action" wire:loading.attr="disabled" class="bg-light form-select" aria-label="State">
                                    <option value="">-Select-</option>
                                    <option value="Approved">Approve</option>
                                    <option value="Declined">Decline</option>
                                </select>
                                @error('action')<span class="error text-danger">*</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-jet-secondary-button class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </x-jet-secondary-button>
                        @if(empty($editStatus))
                        <x-jet-button wire:click="saveAction" wire:loading.attr="disabled" class="btn bg-success btn-secondary">
                            Save
                        </x-jet-button>
                        @else
                        <x-jet-button wire:click="saveAction" wire:loading.attr="disabled" class="btn btn-secondary">
                            Update
                        </x-jet-button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>