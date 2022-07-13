<div>

    <!--Header-->
    <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
        <h1 class="h4">General Information</h1>
        <button class="btn btn-sm btn-secondary" wire:click="clear" wire:loading.attr="disabled">
            {{ __('x') }}
        </button>

    </div>

    <div class="max-filter   bg-white p-3 ">
        <!-- HEADER DETAILS -->
        <div class="d-flex justify-content-between">
            <strong>
                <h1>Requesting Department</h1>
            </strong>
            @if(empty($finalizeData))
            <x-jet-button wire:click="preview" class="p-2">Preview</x-jet-button>
            @else
            <div>
                <x-jet-button wire:click="saveRQR" wire:loading.attr="disabled" class="bg-success p-2">Save</x-jet-button>
                <x-jet-secondary-button wire:click="previewClose" class="p-2">Continue adding</x-jet-secondary-button>
            </div>
            @endif
        </div>
        <!-- Top Form -->
        <div class="row d-flex justify-content-center">

            <!--- REASON -->
            <div class="col-md-8 mt-3" wire:loading.attr="disabled">
                <x-jet-label for="reason" value="Reason" />
                <div class="d-flex">
                    <textarea id="reason" rows="2" cols="50" class="txt-a block mt-1 w-full" type="text" wire:model="reason"> </textarea>
                    @error('reason')<span class="error text-danger">*</span> @enderror
                </div>
            </div>

        </div>

        <hr class="mt-3 mb-3">

        <!-- Items -->
        @if(empty($finalizeData))
        <div class="row mt-2">
            <div class="col-md-4 mb-2 mt-3">
                <div class="text-center">
                    <table class="table table-hover">
                        <thead style="background-color:lightslategrey;" class="p-2 text-white align-items-center">
                            <tr>
                                <th style="text-align:center;">Item / s</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($vals))
                            @for($i=0; $i <= count($vals)-1; $i++) <tr class="itemSelect ">
                                <td class="p-2 " id="{{$vals[$i]['property_number']}}" wire:click="showData('{{$i}}')">
                                    {{$vals[$i]['property_number']}}<br>
                                    <p style="font-size: 10px;">{{substr($vals[$i]['item_description'],0,20)}}...</p>
                                </td>
                                </tr>
                                @endfor
                                @endif
                        </tbody>
                    </table>
                    <div class=" col-md-11 text-center">

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="col-12 p-1 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-bold"><strong>Add item/s</strong></h2>
                    </div>
                    @if(!empty($item))
                    <!--- BUTTONS FOR NEW ITEMS IN RR -->
                    @if(!empty($showbuttonupdate))
                    <div>
                        <!--- BUTTONS FOR UPDATE AND DELETE -->
                        <x-jet-button class="bg-danger btn-sm" wire:click="deleteItem({{$itemid}})" wire:loading.attr="disabled"><i class="bi bi-trash"> Delete</i></x-jet-button>
                        <x-jet-button class="bg-secondary btn-sm" wire:click="clearItems" wire:loading.attr="disabled"><i class="bi bi-backspace"> Cancel</i></x-jet-button>
                    </div>
                    @else
                    <div>
                        <!--- BUTTON FOR ADD -->
                        <x-jet-button class="bg-secondary btn-sm" wire:click="clearItems" wire:loading.attr="disabled"><i class="bi bi-backspace"> Clear</i></x-jet-button>
                        <x-jet-button class="bg-success btn-sm" wire:click="saveItem" wire:loading.attr="disabled"> <i class="bi bi-pencil"></i> Add </x-jet-button>
                    </div>
                    @endif
                    @endif
                </div>
                <div class="row">


                    <!--- Property Code -->
                    <div class="col-md-6 mt-3">
                        <div class="d-flex justify-content-between">
                            <x-jet-label for="prty" value="Property No." />
                            @if(empty($sdata))
                            <button wire:click="find" wire:loading.attr="disabled" class="btn btn-sm bg-warning">
                                <strong>
                                    Find
                                </strong>
                            </button>
                            @endif
                        </div>
                        <div class="d-flex">
                            <x-jet-input id="prty" class="block mt-1 w-full" type="text" wire:model="prty" wire:loading.attr="disabled" />
                            @error('prty')<span class="error text-danger">*</span> @enderror
                        </div>
                    </div>


                    <!--- ITEM -->
                    <div class="col-md-12 mt-3">
                        <x-jet-label for="item" value="{{ __('Item') }}" />
                        <div class="d-flex">
                            <textarea id="item" disabled rows="2" class="txt-a block mt-1 w-full" type="text" wire:model="item"> </textarea>
                        </div>
                    </div>

                    <!--- Serial Code -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="srl" value="Serial No." />
                        <div class="d-flex">
                            <x-jet-input id="srl" disabled class="block mt-1 w-full" type="text" wire:model="srl" />
                        </div>
                    </div>

                    <!--- OUM -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="oum" value="OUM" />
                        <div class="d-flex">
                            <x-jet-input disabled id="oum" class="block mt-1 w-full" type="text" wire:model="oum" />
                        </div>
                    </div>


                    <!--- FEA NO -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="fea" value="FEA No." />
                        <div class="d-flex">
                            <x-jet-input disabled id="fea" class="block mt-1 w-full" type="text" wire:model="fea" />
                        </div>
                    </div>

                    <!--- Acq. Date -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="acq_date" value="Acq. Date" />
                        <div class="d-flex">
                            <x-jet-input disabled id="acq_date" class="block mt-1 w-full" type="text" wire:model="acq_date" />
                        </div>
                    </div>


                    <div class="mt-5"></div>
                </div>
            </div>
        </div>
        @else
        <div class="row mt-2">
            <!--Items Table-->
            <div id="itemtable" class="">
                <div class="col-md-12 overflow-auto" style="max-height: 500px;">
                    <div class="col-md-12 table-responsive p-1">
                        <table class="table table-hover table-bordered">
                            <thead class="text-center">
                                <tr class="">
                                    <th scope="col">Property No.</th>
                                    <th scope="col">OUM</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Serial No.</th>
                                    <th scope="col">Acq. Date</th>
                                    <th scope="col">Fea No.</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if(!empty($itemArray))
                                @foreach($itemArray as $itemf)
                                <tr>
                                    <td>{{$itemf['property_number']}}</td>
                                    <td>{{$itemf['oum']}}</td>
                                    <td>{{$itemf['item_description']}}</td>
                                    <td>{{$itemf['serial_number']}}</td>
                                    <td>{{$itemf['acq_date']}}</td>
                                    <td>{{$itemf['fea_number']}}</td>
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
        @endif



        <!-- Signature -->
        <div class="row mt-2 d-flex justify-content-center border">
            <div class="col-md-5 text-center">
                <div class=" mt-3 d-flex justify-content-center">
                    <input disabled class="text-center signform-open block mt-1 w-full" wire:model="preparedby">
                </div>
                <label class="mb-1  sign-text-open">Prepared by Head Department</label>
                @if(empty($finalizeData))
                <div class=" p-1 d-flex justify-content-center">
                    <button wire:click="esign" class="ms-2 btn btn-sm btn-success mt-1" style="width: 70px; height: 29px;">Sign</button>
                    <button wire:click="clearesign" class="ms-2 btn btn-sm btn-secondary mt-1 me-2 " style="width: 70px; height: 29px;">Clear</button>
                </div>
                @endif
            </div>
        </div>


    </div>

    <style>
        .txt-a {
            border-radius: 10px;
            border: 1px solid lightgray;
        }
    </style>

    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewSuccess" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title">RQR no. {{$rqr_number}} </h5>
                    <button class="btn-close" wire:click="createAgain" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <label style="font-weight: 500;">
                            RQR No. {{$rqr_number}} Submitted Successfully!
                        </label> <br>

                        <label class="mt-5">Do you want to sumbit a request again? <br>or Review your transaction request?</label>

                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        <x-jet-button class="ml-4 btn-sm bg-success" wire:click="createAgain">
                            {{ __('Sumbit Again') }}
                        </x-jet-button>

                        <x-jet-button class="ml-4 btn-sm" wire:click="reviewstatus">
                            {{ __('Review Status') }}
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>