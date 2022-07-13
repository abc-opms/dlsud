<div>
    <div class="row bg-white">

        <div class="col-md-3 bg-white  border">
            <div class="bg-light-gy p-3 border max-filter ">
                <div>
                    <x-jet-label for="skey" class="h2" value="Search FEA No." />
                    <x-jet-input wire:model="search" id="search" class="block mt-1 w-full" type="search" />
                </div>
            </div>


            <!--FEA Numbers-->
            <div class="overflow-auto list-number bg-white max-filter p-2">

                <ul class="nav-parent list-group list-group-flush">
                    <ul class="num-list nav-parent list-group list-group-flush">
                        @if(!empty($feacustodian))
                        @forelse($feacustodian as $val)
                        <li id="{{$val->fea_number}}" class="list-group-item d-flex justify-content-between align-items-center" wire:click="openForm('{{$val->fea_number}}')">
                            FEA {{$val->fea_number}}


                            @if(empty($val->read_at))
                            <span class="badge  rounded-pill text-white p-1" style="background-color: #408AE8;">
                                <i class="bi bi-star-fill"></i> New
                            </span>
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
            @if(empty($feanum))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>

            <!--FORM-->
            @else
            <div>
                <!--Header-->
                <div class="max-form d-flex align-items-center justify-content-between p-2">
                    <h1>Item Table</h1>
                    <button class="btn btn-sm btn-secondary" wire:click="closeForm">
                        {{ __('x') }}
                    </button>
                </div>

                <div class="d-flex justify-content-between p-1">
                    <label class="me-1">FEA no.: <strong>{{$feanum}}</strong></label>
                    @if(!empty($receivedby))
                    <button wire:click="saveSign" class="btn  btn-success btn-save">Save</button>
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

                        <!--Other info-->
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
                                            <label for="" class="me-1">PO No.:</label>
                                        </td>
                                        <td>
                                            <x-jet-input wire:model="ponum" disabled class="block mt-1 w-full text-dark" type="text" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Table -->
                <div class="max-form d-flex align-items-center justify-content-between p-2">
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
                                    <th scope="col">Serial no.</th>
                                    <th scope="col">Unit Cost</th>
                                    <th scope="col">Amount</th>
                                    <th " scope=" col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if(!empty($items))
                                @foreach($items as $itemf)
                                <tr>
                                    <td>{{$itemf->deliver_qty}} {{$itemf->oum}}</td>
                                    <td>
                                        {{$itemf->name}} <br>
                                        {{$itemf->item_description}}
                                    </td>
                                    <td>
                                        @foreach($prop as $e)
                                        @if($e->rritems_id == $itemf->id)
                                        <p>- {{$e->property_code}}</p>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($prop as $e)
                                        @if($e->rritems_id == $itemf->id)
                                        <p>- {{$e->serial_number}}</p>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>&#8369; {{$itemf->unit_cost}}</td>
                                    <td>&#8369; {{$itemf->amount}}</td>
                                    <td>Acc. code: <strong>{{$itemf->acc_code}}</strong></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- End Table-->
                    </div>
                </div>

                <hr style="border: 1px solid;">

                <!-- Total -->
                <div class="p-2 d-flex flex-row-reverse">
                    <h1 class="me-3"><strong>{{$totalAmount}}</strong></h1>
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
                                <input readonly class="sigform-disabale w-full" wire:model="checkedby">
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
                                <strong><u> [{{$subdept_code}}/{{$department}}] - {{$subdept_name}} </u></strong>
                            </label>
                        </div>
                        <div class="row mt-2 justify-content-between">
                            <div class="col-md-6 p-3" style="max-width: 400px;">
                                <label class="me-1 sig-text">Received by:</label>
                                <input disabled class="signform-open text-center w-full" wire:model="receivedby">
                            </div>

                            <div class="col-md-6 p-3" style="max-width: 400px;">
                                <label class="me-1 sig-text">Noted by:</label>
                                <input disabled class="signform-open text-center w-full" wire:model="rnotedby">
                            </div>
                        </div>
                        <div class=" p-1 d-flex justify-content-center mb-2">
                            <button wire:click="esign" class="ms-2 btn btn-sm btn-success mt-1" style="width: 70px; height: 29px;">Sign</button>
                            <button wire:click="clearesign" class="ms-2 btn btn-sm btn-secondary mt-1 me-2 " style="width: 70px; height: 29px;">Clear</button>
                        </div>
                    </div>
                </div>
                <!-- End of form -->

            </div>
            @endif
        </div>

    </div>
</div>