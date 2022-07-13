<div>
    <div class="row bg-white">

        <div class="col-md-3 bg-white margin-down border">
            <div class="bg-light-gy p-2 border max-filter mb-3">
                <div class=" mb-3">
                    <x-jet-label for="skey" class="h2" value="Search RQR No." />
                    <x-jet-input id="search" class="block mt-1 w-full" type="search" wire:model="search" />
                </div>

                <hr>
                <div class="mt-3 d-flex justify-content-center">
                    <a href="/create/qrretagging" class="text-success crt">
                        Create <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            </div>

            <!--FEA Numbers-->
            <div class="overflow-auto list-number bg-white max-filter p-2">

                <ul class="num-list nav-parent list-group list-group-flush">
                    @if(!empty($rqr_cus))
                    @foreach($rqr_cus as $r)
                    <li id="{{$r->rqr_number}}" wire:click="showdata('{{$r->id}}')" class="list-group-item d-flex justify-content-between align-items-center">
                        {{$r->rqr_number}}

                        @if($r->status == "Active")
                        <span class="badge  rounded-pill text-white" style="background-color: #90AEAD;">Pending</span>
                        @elseif($r->status == "Done")
                        <span class="badge  rounded-pill text-white" style="background-color: #78B087;">{{$r->status}}</span>
                        @else
                        <!--DONE NO SPAN-->
                        @endif
                    </li>
                    @endforeach
                    @else
                    <p class="text-center">No forms yet</p>
                    @endif
                </ul>
            </div>
        </div>


        <div class="col-md-9 min-height-form" id="form-content">
            @if(empty($rqr_number))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>

            @else
            <!--Header-->
            <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
                <h5 class="mt-1">General Information</h5>
                <button class="btn btn-sm btn-secondary" wire:click="clear">
                    {{ __('x') }}
                </button>
            </div>
            <div class="p-1">
                <h6 class="mt-1">RQR No. {{$rqr_number}}</h6>
            </div>

            <div class="col-md-12 bg-white p-2">
                <!-- HEADER DETAILS -->
                <div class="row">
                    <div class="col-md-6 mt-1">
                        <table style="width: 95%;">
                            <tr>
                                <td>Name:</td>
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
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @if(!empty($ItemArray))
                                        @foreach($ItemArray as $i)
                                        <tr>
                                            @if(!empty($i->oum))
                                            <td>1</td>
                                            <td>
                                                {{$i->oum}}
                                            </td>

                                            <td>
                                                {{$i->name}}<br>
                                                {{$i->item_description}}
                                            </td>
                                            <td>
                                                @if(!empty($i->serial_number))
                                                {{$i->serial_number}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{$i->property_code}}</td>
                                            <td>{{$i->acq_date}}</td>
                                            <td>{{$i->fea_number}}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @endif
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
            @endif

        </div><!--  End of form -->
    </div>




</div>