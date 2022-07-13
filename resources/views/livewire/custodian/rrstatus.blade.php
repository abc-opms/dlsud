<div>
    <div class="row bg-white">

        <div class="col-md-3 bg-white margin-down border">
            <div class="bg-light-gy p-2 border max-filter mb-3">
                <div class=" mb-3">
                    <x-jet-label for="skey" class="h2" value="Search RR No." />
                    <x-jet-input id="search" class="block mt-1 w-full" type="search" wire:model="search" />
                </div>
            </div>

            <div class="overflow-auto list-number bg-white max-filter p-2">
                <ul class="num-list nav-parent list-group list-group-flush">
                    @if(Auth::user()->hasRole('Custodian'))
                    @forelse($rrc as $r)
                    <li id="{{$r->rr_number}}" class="list-group-item d-flex justify-content-between align-items-center" wire:click="showdata({{$r->id}})">
                        {{$r->rr_number}}

                        @if($r->status == "Active")
                        <span class="badge  rounded-pill text-white" style="background-color: #2E8A88;">{{$r->status}}</span>
                        @elseif($r->status == "Ongoing")
                        <span class="badge  rounded-pill text-white" style="background-color: #64C3C1;">{{$r->status}}</span>
                        @elseif($r->status == "Declined")
                        <span class="badge  rounded-pill bg-secondary">{{$r->status}}</span>
                        @elseif($r->status == "Done")
                        <span class="badge  rounded-pill text-white" style="background-color: #81B79C;">{{$r->status}}</span>
                        @else
                        <!--DONE NO SPAN-->
                        @endif
                    </li>
                    @empty
                    <p class="text-center">No data available</p>
                    @endforelse


                    @else
                    @forelse($rr as $r)
                    <li id="{{$r->rr_number}}" class="list-group-item d-flex justify-content-between align-items-center" wire:click="showdata({{$r->id}})">
                        {{$r->rr_number}}

                        @if($r->status == "Active")
                        <span class="badge  rounded-pill text-white" style="background-color: #2E8A88;">{{$r->status}}</span>
                        @elseif($r->status == "Ongoing")
                        <span class="badge  rounded-pill text-white" style="background-color: #64C3C1;">{{$r->status}}</span>
                        @elseif($r->status == "Declined")
                        <span class="badge  rounded-pill bg-secondary">{{$r->status}}</span>
                        @elseif($r->status == "Done")
                        <span class="badge  rounded-pill text-white" style="background-color: #81B79C;">{{$r->status}}</span>
                        @else
                        <!--DONE NO SPAN-->
                        @endif
                    </li>
                    @empty
                    <p class="text-center">No data available</p>
                    @endforelse
                    @endif

                </ul>
            </div>
        </div>


        <div class="col-md-9 min-height-form" id="form-content">
            @if(empty($rr_number))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>

            @else
            <!--Header-->
            <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
                <h1 class="h4">General Information</h1>
                <button class="btn btn-sm btn-secondary" wire:click="clear">
                    {{ __('x') }}
                </button>
            </div>
            <div class="max-form-sub d-flex align-items-center justify-content-between p-1">
                <div class="d-flex ms-2">
                    <h6>RR No: </h6>
                    <h6><strong>&#160; {{$rr_number}}</strong></h6>
                </div>

                @if(!empty($fea_number))
                <div class="d-flex ms-2">
                    <h6>FEA No: </h6>
                    <h6><strong>&#160; {{$fea_number}}</strong></h6>
                </div>
                @endif
            </div>

            @if(!empty($checkedby))
            <div class="col-md-12 d-flex justify-content-center mt-2">
                @if(Auth::user()->hasRole('Custodian'))
                <a href="/c/export-receivingreport/{{$rr_number}}" target="blank">
                    <x-jet-button class="ml-4 bg-success">
                        {{ __('Export PDF') }}
                    </x-jet-button>
                </a>
                @endif

                @if(Auth::user()->hasRole('Warehouse'))
                <a href="/export-receivingreport/{{$rr_number}}" target="blank">
                    <x-jet-button class="ml-4 bg-success">
                        {{ __('Export PDF') }}
                    </x-jet-button>
                </a>
                @endif
            </div>
            @endif
            <div class="col-md-12 bg-white p-2">


                <!-- HEADER DETAILS -->
                <div class="row">

                    <!--- SUPPLIER ID -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="s_id" value="{{ __('Supplier Name') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="delivery_date" class="block mt-1 w-full" type="text" wire:model="supplier_code" />
                        </div>
                    </div>

                    <!--- DELIVERY DATE -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="delivery_date" value="{{ __('Delivery Date') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="delivery_date" class="block mt-1 w-full" type="date" wire:model="delivery_date" />
                        </div>
                    </div>

                    <!--- INVOICE / OR -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="invoice" value="{{ __('Invoice/OR') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="invoice" class="block mt-1 w-full" type="text" wire:model="invoice" />
                        </div>
                    </div>

                    <!--- INVOICE DATE -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="invoice_date" value="{{ __('Invoice Date') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="invoice_date" class="block mt-1 w-full" type="date" wire:model="invoice_date" />
                        </div>
                    </div>

                    <!--- PO NUMBER -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="ponum" value="{{ __('PO No.') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="ponum" class="block mt-1 w-full" type="text" wire:model="ponum" />
                        </div>
                    </div>

                    <!--- Department -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="s_id" value="{{ __('Department') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="delivery_date" class="block mt-1 w-full" type="text" wire:model="dept_code" />
                        </div>
                    </div>


                    <!--- Total Amount -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="total" value="{{ __('Total') }}" />
                        <div class="d-flex">
                            <x-jet-input disabled id="total" class="block mt-1 w-full" type="text" wire:model="total" />
                        </div>
                    </div>


                    <!--- Received by -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="receipt" value="{{ __('Receipt') }}" />
                        <div class="d-flex">
                            <x-jet-secondary-button data-bs-toggle="modal" data-bs-target="#viewReceipt" class="block mt-1 w-full text-center">
                                Show Receipt
                            </x-jet-secondary-button>
                        </div>
                    </div>



                    <!--- RECEIPT -->
                    <div class="col-md-6 mt-3 ow mb-3">
                        <div class="d-flex justify-content-between">
                            <x-jet-label for="receivedby" value="{{ __('Received by') }}" />
                        </div>
                        <x-jet-input disabled id="total" class="block mt-1 w-full" type="text" wire:model="receivedby" />
                    </div>

                </div>
            </div>
            <div class="max-form d-flex align-items-center justify-content-between p-2">
                <h1>Item Table</h1>
            </div>
            <div>
                <div class="row">

                    <!--Items Table-->
                    <div id="itemtable" class="">
                        <div class="col-md-12 overflow-auto" style="max-height: 500px;">
                            <div class="col-md-12 table-responsive p-1">
                                <table class="table table-hover table-bordered">
                                    <thead class="text-center">
                                        <tr class="">
                                            <th scope="col">Acc. Code</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">OUM</th>
                                            <th scope="col">Unit Cost</th>
                                            <th scope="col">Order Qty</th>
                                            <th scope="col">Deliver Qty</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @if(!empty($ItemArray))
                                        @foreach($ItemArray as $itemf)
                                        <tr>
                                            <td>{{$itemf->acc_code}}</td>
                                            <td>
                                                {{$itemf->name}}<br>
                                                {{$itemf->item_description}}
                                            </td>
                                            <td>{{$itemf->oum}}</td>
                                            <td>&#8369; {{$itemf->unit_cost}}</td>
                                            <td>{{$itemf->order_qty }}</td>
                                            <td>{{$itemf->deliver_qty}}</td>
                                            <td>&#8369; {{$itemf->amount}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <!-- End Table-->
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px solid;">

                <!-- Total -->
                <div class="p-2 d-flex flex-row-reverse">
                    <h1 class="me-3"><strong>{{$sum}}</strong></h1>
                    <h3 class="me-3">Total:</h3>
                </div>

                <hr style="border: 1px solid;">


                <!-- Signature -->
                <div class="row  mt-2 d-flex justify-content-center border">
                    <div class="sign_container p-3  d-flex mb-3">
                        <div class="col-s mt-3 me-5">
                            <label class="mb-1  sig-text-disbale">Prepared by:</label><br>
                            <input disabled class="sigform-disabale text-center block mt-1 w-full" wire:model="preparedby">
                        </div>

                        <div class="col-s mt-3">
                            <label class="mb-1  sig-text-disbale">Checked by:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 text-center w-full" wire:model="checkedby">
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div><!--  End of form -->
    </div>



    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewReceipt" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <label class="receipt-title">RECEIPT of RR no. {{$rr_number}}</label>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">

                    @if (!empty($receipt))
                    <div>
                        <img src="/storage/receipt/{{$receipt}}" class="img-fluid receipt-p" alt="Responsive image">
                    </div>
                    @else
                    <div>
                        <label class="receipt-title">NO RECEIPT AVAILABLE</label>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <x-jet-secondary-button class="ml-4 btn-sm" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>

</div>