<div>
    <div class="row bg-white">

        <div class="col-md-3 bg-white  border">
            <div class="bg-light-gy p-3 border max-filter ">
                <div>
                    <x-jet-label for="skey" class="h2" value="Search RR No." />
                    <x-jet-input wire:model="search" id="search" class="block mt-1 w-full" type="search" />
                </div>
            </div>

            <!--FEA Numbers-->
            <div class="overflow-auto list-number bg-white max-filter p-2">

                <ul class="nav-parent list-group list-group-flush">
                    <ul class="num-list nav-parent list-group list-group-flush">
                        @forelse($rrnums as $r)
                        <li id="{{$r->rr_number}}" class="list-group-item d-flex justify-content-between align-items-center" wire:click="createFEA('{{$r->rr_number}}')">
                            {{$r->rr_number}}

                            @if(empty($r->read_at))
                            <span class="badge  rounded-pill text-white p-1" style="background-color: #408AE8;">
                                <i class="bi bi-star-fill"></i> New
                            </span>
                            @endif

                        </li>
                        @empty
                        <p class="text-center mt-3">No RR available</p>
                        @endforelse

                    </ul>
            </div>
        </div>


        <div class="col-md-9 min-height-form mb-2" id="form-content">
            @if(empty($hideRRnum))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>
            <!--FORM-->
            @else
            <div>
                <!--Header-->
                <div class="max-form d-flex align-items-center justify-content-between p-2">
                    <h1>General Information</h1>

                    <button class="btn btn-sm btn-secondary" wire:click="closecreateFEA">
                        {{ __('x') }}
                    </button>
                </div>

                <div class="d-flex justify-content-between p-1">
                    <label class="me-1">RR no.: <strong>{{$rrnum}}</strong></label>
                    @if(!empty($checkedby))
                    <button wire:click="preview" class="btn  btn-success btn-save">FINALIZE</button>
                    @endif
                </div>
                <div class="col-md-12 ">
                    <div class="row justify-content-between mb-3 mt-3">
                        <!--Supplier-->
                        <div class="col-md-7">
                            <div class="col-md-12 d-flex mt-1">
                                <label class="me-2">Supplier:</label>
                                <x-jet-input wire:model="name" id="supplier" disabled class="block mt-1 w-full text-dark" type="text" />
                            </div>
                            <div class="col-md-12 d-flex mt-1 ">
                                <label class="me-2">Address:</label>
                                <textarea disabled wire:model="address" class="txtarea mt-1 w-full text-dark"></textarea>
                            </div>
                            <div class="col-md-12 d-flex mt-1">
                                <label class="me-2">Tel & Fax no.</label>
                                <x-jet-input wire:model="telnum" id="tenum" disabled class="block mt-1 w-full text-dark" type="text" />
                            </div>
                        </div>
                        <!--End of Supplier-->
                        <!--Right Header-->
                        <div class="col-md-5">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="me-2">Delivery Date:</label>

                                        </td>
                                        <td>
                                            <x-jet-input wire:model="delivery_date" disabled class="block mt-1 w-full text-dark" type="date" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="me-2 ">Invoice Date:</label>
                                        </td>
                                        <td>
                                            <x-jet-input wire:model="invoice_date" disabled class="block mt-1 w-full text-dark" type="date" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="" class=" me-1">Supplier Invoice:</label>
                                        </td>
                                        <td>
                                            <x-jet-input wire:model="invoice" disabled class="block mt-1 w-full text-dark" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="" class="me-1">PO / RR No.:</label>
                                        </td>
                                        <td>
                                            <x-jet-input wire:model="po_rr" disabled class="block mt-1 w-full text-dark" type="text" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--End of Right Header-->

                    </div>
                </div>

                <!-- Table -->
                <div class="max-form-item d-flex align-items-center justify-content-between p-2">
                    <h1>Item Table</h1>
                </div>
                <div class="col-md-12 overflow-auto" style="max-height: 400px;">
                    <!-- Start of Div Table -->
                    <div class="col-md-12 table-responsive p-1">
                        <!-- Start of Item Table-->
                        <table class="table table-hover table-bordered">
                            <thead class="text-center">
                                <tr class="">
                                    <th scope="col">Qty / Unit</th>
                                    <th scope="col">Item / Description</th>
                                    <th scope="col">Prop. Code</th>
                                    <th scope="col">Serial. Code</th>
                                    <th scope="col">Unit Cost</th>
                                    <th scope="col">Amount</th>
                                    <th scope=" col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($items as $itemf)
                                <tr>
                                    <td>{{$itemf->deliver_qty }} {{$itemf->oum}}</td>
                                    <td>
                                        {{$itemf->name}}<br>
                                        {{$itemf->item_description}}
                                    </td>
                                    <td>
                                        @forelse($prop as $e)
                                        @if($e->rritems_id == $itemf->id)
                                        <p>-{{$e->property_code}}</p>
                                        @endif
                                        @empty
                                        <p> - </p>
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse($prop as $e)
                                        @if($e->rritems_id == $itemf->id)
                                        @if(empty($e->serial_number))
                                        <button wire:click="openSerialModal('{{$itemf->id}}', '{{$itemf->item_description}}', '{{$e->property_code}}')" class="btn btn-sm border bg-warning">
                                            <strong>Add</strong>
                                        </button> <br>
                                        <hr class="mb-1 mt-1">
                                        @else
                                        <p> {{$e->serial_number}}
                                            <strong><i wire:click="editSerial('{{$e->serial_number}}','{{$itemf->item_description}}')" class="bi bi-pencil-square text-success"></i></strong>
                                            <strong><i wire:click="deleteSerial('{{$e->serial_number}}', '{{$e->id}}')" class="bi bi-trash-fill text-danger"></i></strong>
                                        </p>
                                        <hr class="mb-1 mt-1">
                                        @endif
                                        @endif
                                        @empty
                                        <p> - </p>
                                        @endforelse
                                    </td>
                                    <td>&#8369; {{$itemf->unit_cost}}</td>
                                    <td>&#8369; {{$itemf->amount}}</td>
                                    <td>Acc. code: {{$itemf->acc_code}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table-->
                    </div>
                </div>

                <hr style="border: 1px solid;">

                <!-- Total -->
                <div class="p-2 d-flex flex-row-reverse">
                    <h1 class="me-3"><strong> {{$totalAmount}}</strong></h1>
                    <h3 class="me-3">Total:</h3>
                </div>

                <hr style="border: 1px solid;">

                <!-- Signature -->
                <div class="row d-flex mt-5 align-items-start border">

                    <div class="col-md-5 mb-3">
                        <label style="font-size: 15px;">Accounting/Property Acknowledgement</label>

                        <div class="row mt-2 justify-content-between">
                            <div class="col-md-12 " style="max-width: 400px;">
                                <label class="me-1 sig-text">Item Checked by:</label>
                                <input readonly class="signform-open text-center w-full" wire:model="checkedby">
                            </div>

                            <div class=" p-1 d-flex justify-content-center">
                                <button wire:click="esign" class="ms-2 btn btn-sm btn-success mt-1" style="width: 70px; height: 29px;">Sign</button>
                                <button wire:click="clearesign" class="ms-2 btn btn-sm btn-secondary mt-1 me-2 " style="width: 70px; height: 29px;">Clear</button>
                            </div>

                            <div class="col-md-12" style="max-width: 400px;">
                                <label class="me-1 sig-text">Noted by:</label>
                                <input readonly class="sigform-disabale w-full" wire:model="notedby">
                            </div>

                            <div class="col-md-12 " style="max-width: 400px;">
                                <label class="me-1 sig-text">Recorded by:</label>
                                <input readonly class="sigform-disabale w-full" wire:model="recordedby">
                            </div>
                        </div>

                    </div>


                    <div class="col-md-7 ">
                        <div>
                            <label class="text-wrap" style="font-size: 12px;"><strong>
                                    This is to certify that I received the following equipment/furniture from Accounting Office/Property Section for which I am responsible. In case of loss and if it could be proven that the loss was due to my negligence, I will pay the for above item(s). In the event of loss, it is my duty to report to the security office within 72 hours. Failure to do so means administrative negligence of my part.
                                </strong></label>
                        </div>

                        <div>
                            <label class="me-1 mt-1 sig-text">Department:
                                <strong><u> [{{$subdept}}/{{$department}}] - {{$dept_name}} </u></strong>
                            </label>
                        </div>
                        <div class="row mt-2 justify-content-between">
                            <div class="col-md-6 p-3" style="max-width: 400px;">
                                <label class="me-1 sig-text">Received by:</label>
                                <input disabled class="sigform-disabale w-full" wire:model="">
                            </div>

                            <div class="col-md-6 p-3" style="max-width: 400px;">
                                <label class="me-1 sig-text">Noted by:</label>
                                <input disabled class="sigform-disabale w-full" wire:model="notedby">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of form -->
            </div>
        </div>
        @endif
    </div>


    <!-- Add  Edit Serial Modal -->
    <div wire:ignore.self class="modal fade" id="AddSerialModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">{{$Itemname}}</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <label for="">@if(empty($snum))Add @else Edit @endif Serial Code</label>
                    <x-jet-input wire:model="serial" id="supplier" class="block mt-1 w-full text-dark" type="text" />

                </div>
                <div class="modal-footer">
                    <x-jet-secondary-button wire:click="cancelAES" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
                    @if(empty($snum))
                    <x-jet-button wire:click="saveSerialCode" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-jet-button>
                    @else
                    <x-jet-button wire:click="updateS" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-jet-button>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- End of Add  Edit Serial Modal-->

    <!-- Delte Confitmation Modal-->
    <div class="modal fade" id="deleteSerial" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Delete <strong class="text-success">{{$snum}}</strong></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this serial number? You cannot undo this changes.
                    <div class="d-flex justify-content-center mt-3">
                        <x-jet-secondary-button wire:click="cancelDS">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-danger-button class="ms-2" wire:click="deleteS" wire:loading.attr="disabled">
                            {{ __('Yes, Delete') }}
                        </x-jet-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Preview Modal-->

    <div class="modal fade" id="previewFea" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save FEA</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-4 text-success">
                        <strong>
                            Please keep in mind that once you save this form, it cannot be deleted or changed.
                        </strong>
                    </p>
                    <div class="row">
                        <div class="col-md-3 mt-1">
                            <label class="me-2">RR no.:</label>
                            <x-jet-input wire:model="rrnum" id="rrnum" disabled class="block mt-1 w-full text-dark" type="text" />
                        </div>

                        <div class="col-md-3 mt-1">
                            <label class="me-2">Supplier:</label>
                            <x-jet-input id="supplier" wire:model="name" disabled class="block mt-1 w-full text-dark" type="text" />
                        </div>

                        <div class="col-md-3 mt-1">
                            <label class="me-2">Sub Department:</label>
                            <x-jet-input wire:model="name" id="dept_name" disabled class="block mt-1 w-full text-dark" type="text" />
                        </div>

                        <div class="col-md-3 mt-1">
                            <label class="me-2">Received by:</label>
                            <x-jet-input id="rby" wire:model="rby" disabled class="block mt-1 w-full text-dark" type="text" />
                        </div>
                    </div>

                    <div class="col-md-12 table-responsive p-1 mt-3">
                        <!-- Start of Item Table-->
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr class="">
                                    <th scope="col">Qty / Unit</th>
                                    <th scope="col">Item / Description</th>
                                    <th scope="col">Prop. Code</th>
                                    <th scope="col">Serial. Code</th>
                                    <th scope="col">Unit Cost</th>
                                    <th scope="col">Amount</th>
                                    <th scope=" col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($items as $itemf)
                                <tr>
                                    <td>{{$itemf->deliver_qty }} {{$itemf->oum}}</td>
                                    <td>
                                        {{$itemf->name}}<br>
                                        {{$itemf->item_description}}
                                    </td>
                                    <td>
                                        @if(!empty($prop))
                                        @foreach($prop as $e)
                                        @if($e->rritems_id == $itemf->id)
                                        <p>{{$e->property_code}}</p>
                                        @endif
                                        @endforeach
                                        @else
                                        <p> - </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($prop))
                                        @forelse($prop as $e)
                                        @if($e->rritems_id == $itemf->id)
                                        @if(empty($e->serial_number))
                                        <p> - </p>
                                        @else
                                        <p>{{$e->serial_number}}</p>
                                        @endif
                                        @endif

                                        @empty
                                        <p> - </p>
                                        @endforelse
                                        @endif
                                    </td>
                                    <td>&#8369; {{$itemf->unit_cost}}</td>
                                    <td>&#8369; {{$itemf->amount}}</td>
                                    <td>Acc. code: {{$itemf->acc_code}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table-->
                    </div>

                </div>
                <div class="modal-footer">
                    <x-jet-button data-bs-dismiss="modal" wire:click="savefea" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-jet-button>
                    <x-jet-secondary-button data-bs-dismiss="modal" wire:loading.attr="disabled">
                        {{ __('Continue Editing') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>

</div>