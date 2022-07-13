<div>
    <div class="row bg-white">

        <div class="col-md-3 bg-white margin-down border">
            <div class="bg-light-gy p-2 border max-filter mb-3">
                <div class=" mb-3">
                    <x-jet-label for="skey" class="h2" value="Search RR No." />
                    <x-jet-input id="search" class="block mt-1 w-full" type="search" wire:model="search" />
                </div>
            </div>

            <!--FEA Numbers-->
            <div class="overflow-auto list-number bg-white max-filter p-2">

                <ul class="num-list nav-parent list-group list-group-flush">
                    @if(Auth::user()->hasRole('Custodian'))
                    @forelse($rdf_cus as $r)
                    <li id="{{$r->rdf_number}}" class="list-group-item d-flex justify-content-between align-items-center" wire:click="showdata({{$r->id}})">
                        {{$r->rdf_number}}

                        @if($r->status == "Pending")
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
                    @forelse($rdf as $r)
                    <li id="{{$r->rdf_number}}" class="list-group-item d-flex justify-content-between align-items-center" wire:click="showdata({{$r->id}})">
                        {{$r->rdf_number}}

                        @if($r->status == "Pending")
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
            @if(empty($rdf_number))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>

            @else
            <!--Header-->
            <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
                <h5 class="mt-1">RDF No. <strong class="underline">{{$rdf_number}}</strong></h5>
                <button class="btn btn-sm btn-secondary" wire:click="clear">
                    {{ __('x') }}
                </button>
            </div>
            <div class="max-form-sub  align-items-center p-1 text-center ">
                <h6 class="mt-1">Request for Disposal of Furniture/Equipment</h6>
            </div>

            @if(!empty($postedby))
            <div class="col-md-12 d-flex justify-content-center mt-2">
                <a href="/export-itemdisposal/{{$rdf_number}}">
                    <x-jet-button class="ml-4 bg-success">
                        {{ __('Export PDF') }}
                    </x-jet-button>
                </a>
            </div>
            @endif
            <div class="col-md-12 bg-white p-2">


                <!-- HEADER DETAILS -->
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <table style="width: 95%;">
                            <tr>
                                <td>TO:</td>
                                <td>
                                    <input value="Finance Office-Property Section" class="inpur-underline block mt-1 w-full">
                                </td>
                            </tr>
                            <tr>
                                <td>FROM:</td>
                                <td>
                                    <input disabled wire:model="from" class="inpur-underline block mt-1 w-full">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 mt-3">
                        <table style="width: 90%;">
                            <tr>
                                <td>DATE:</td>
                                <td>
                                    <input disabled wire:model="date" class="inpur-underline block mt-1 w-full">
                                </td>
                            </tr>
                            <tr>
                                <td>DEPT/UNIT:</td>
                                <td>
                                    <input disabled wire:model="dept" class="inpur-underline block mt-1 w-full">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- ITEMS -->

                <div class="mt-5 row">
                    <label for="">
                        This is to request for the disposal of the following furniture/equipement.
                    </label>

                    <!--Items Table-->
                    <div id="itemtable" class="mt-1">
                        <div class="col-md-12 overflow-auto" style="max-height: 500px;">
                            <div class="col-md-12 table-responsive p-1">
                                <table class="table table-hover table-bordered">
                                    <thead class="text-center">
                                        <tr class="">
                                            <th scope="col">Qty</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">item/Description</th>
                                            <th scope="col">Serial No.</th>
                                            <th scope="col">Fea No.</th>
                                            <th scope="col">Acq. Date</th>
                                            <th scope="col">property No.</th>
                                            <th scope="col">ICTC/ BFMO Evaluation/Remarks</th>
                                            <th scope="col">Recommendation / Action to be</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse($ItemArray as $i)
                                        <tr>
                                            <td>{{$i->qty}}</td>
                                            <td>{{$i->unit}}</td>
                                            <td>{{$i->item_description}}</td>
                                            <td>
                                                @if(!empty($i->serial_number))
                                                {{$i->serial_number}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{$i->fea_number}}</td>
                                            <td>{{$i->acq_date}}</td>
                                            <td>{{$i->property_number }}</td>
                                            <td>{{$i->remarks}}</td>
                                            <td>{{$i->action}}</td>
                                        </tr>

                                        @empty

                                        @endforelse
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

                <style>
                    .sig-label {
                        margin-top: -1px;
                        text-align: center;
                        font-size: 12px;
                        font-weight: 700;
                    }
                </style>


                <!-- Signature -->
                <div class="row  mt-5 d-flex justify-content-center">
                    <div class="col-md-4 p-3  mb-3 border">
                        <div class="col-md-12 mt-3">
                            <label class="mb-1">Reason for Disposal:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 w-full" wire:model="reason">
                        </div>

                        <div class="col-md-12 mt-5">
                            <label class="mb-1 ">Endorsed to Warehouse:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 w-full" wire:model="endorsedto">
                        </div>
                    </div>
                    <div class="col-md-4 p-3  mb-3 border">
                        <div class="col-md-12 mt-3">
                            <label class="mb-1 ">Item/s Checked by:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 w-full" wire:model="checkedby">
                            <div class="col-md-12 text-center">
                                <label class=" sig-label">Property Representative / Date</label>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="mb-1">Approved by:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 w-full" wire:model="approvedby">
                            <div class="col-md-12 text-center">
                                <label class=" sig-label">Diance Director / Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 p-3 mb-3 border">
                        <div class="col-md-12 mt-3">
                            <label class="mb-1">Evaluated by:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 w-full" wire:model="evaluatedby">
                            <div class="col-md-12 text-center">
                                <label class=" sig-label">ICTC / BFMO Staff / Date</label>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="mb-1">Noted by:</label> <br>
                            <input disabled class="sigform-disabale block mt-1 w-full" wire:model="notedby">
                            <div class="col-md-12 text-center">
                                <label class=" sig-label">ICTC / BFMO Director / Date</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex mt-4">
                    <div class="d-flex me-3 col-5">
                        <label class="sig-label col-3">Posted by:</label>
                        <input disabled class="sigform-disabale block mt-1 w-full" wire:model="postedby">
                    </div>

                    <div class="d-flex me-3 col-3">
                        <label class="sig-label me-3">Date: </label>
                        <input disabled class="sigform-disabale block mt-1 w-full" wire:model="posted_date">
                    </div>
                </div>
            </div>
            @endif

        </div><!--  End of form -->
    </div>




</div>