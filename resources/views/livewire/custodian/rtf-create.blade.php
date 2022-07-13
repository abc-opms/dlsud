<div>

    <!--Header-->
    <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
        <h1 class="h4">General Information</h1>
        <button class="btn btn-sm btn-secondary" wire:click="closeRTF">
            {{ __('x') }}
        </button>

    </div>

    <div class="max-filter   bg-white p-3 ">
        <!-- HEADER DETAILS -->
        <div class="d-flex justify-content-between">
            <strong>
                <h1>Requesting Department</h1>
            </strong>
            <button wire:click="saveRTF" wire:loading.attr="disabled" class="btn btn-sm btn-success btn-save p-2">
                SAVE TRANSACTION
            </button>
        </div>

        <!-- Top Form -->
        <div class="row">

            <!--- REASON -->
            <div class="col-md-8 mt-3 ms-5">
                <x-jet-label for="ponum" value="Reason" />
                <div class="d-flex">
                    <x-jet-input id="prty" class="block mt-1 w-full" type="text" wire:model="reason" />
                    @error('reason')<span class="error text-danger">*</span> @enderror
                </div>
            </div>


        </div>

        <hr class="mt-3 mb-3">

        <!-- Items -->
        <div class="row mt-2">
            <div class="col-md-4 mb-2 mt-3">
                <div class="text-center">
                    <table class="table table-hover">
                        <thead style="background-color:lightslategrey;" class="p-2 text-white align-items-center">
                            <tr>
                                <th style="text-align:center;">Item / s</th>
                            </tr>
                        </thead>
                        <tbody>forelse
                            @if(!empty($vals))
                            @for($i=count($vals)-1; $i >= 0; $i--) <tr>
                                <td class="p-2" class="inv-item" wire:click="showData('{{$i}}')">{{$vals[$i]['property_number']}}</td>
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
                        @if(!empty($name))
                        <x-jet-button class="bg-success btn-sm" wire:click="saveItem" wire:loading.attr="disabled"> <i class="bi bi-pencil"></i> Add </x-jet-button>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="row">


                    <div class="col-md-12 row">
                        <!--- Property Code -->
                        <div class="col-md-6 mt-3">
                            <div class="d-flex justify-content-between">
                                <x-jet-label for="prty" value="Property No." />
                                <button wire:click="find" class="btn btn-sm bg-warning">
                                    <strong>
                                        Find
                                    </strong>
                                </button>
                            </div>
                            <div class="d-flex">
                                <x-jet-input id="prty" class="block mt-1 w-full" type="text" wire:model="prty" />
                                @error('prty')<span class="error text-danger">*</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!--- Name -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="name" value="Name" />
                        <div class="d-flex">
                            <x-jet-input id="name" disabled class="block mt-1 w-full" type="text" wire:model="name" />
                        </div>
                    </div>

                    <!--- Serial Code -->
                    <div class="col-md-6 mt-3">
                        <x-jet-label for="srl" value="Serial No." />
                        <div class="d-flex">
                            <x-jet-input id="srl" disabled class="block mt-1 w-full" type="text" wire:model="srl" />
                        </div>
                    </div>

                    <!--- ITEM -->
                    <div class="col-md-12 mt-3">
                        <x-jet-label for="item" value="{{ __('Item') }}" />
                        <div class="d-flex">
                            <textarea id="item" disabled rows="2" class="txt-a block mt-1 w-full" type="text" wire:model="item"> </textarea>
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



        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-7 p-3  mb-3 border">
                    <p style="font-size: 13px;">
                        Note: This is to cerity that I recived the following equipment/furniture
                        from other deperatment/colleges for which I am responsibile.
                        In case of loss and if I could be proven thta the loss was due
                        to my negligence, I will pay for the above item(s). In the event of loss,
                        it is my duty to report to the security officer within 72 hours.
                        Failure to do so means administrative negligence on my part.
                    </p>
                </div>

                <div class="col-md-5 p-3  mb-3 border">
                    <table style="width: 100%;">
                        <tr>
                            <td class="col-4">Receiving Dept:</td>
                            <td class="col-8">
                                <div class="d-flex">
                                    <input disabled class="sigform-disabale block mt-1 w-full" wire:model="r_dept">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Custodian:</td>
                            <td class="d-flex">
                                <select class="form-select" aria-label="State" wire:model="custodian">
                                    <option value="">--Select--</option>
                                    @foreach($cus as $d)
                                    <option value="{{$d->school_id}}">{{$d->last_name}}, {{$d->first_name}}</option>
                                    @endforeach
                                </select>
                                @error('custodian')<span class="error text-danger">*</span> @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Dept./Unit:</td>
                            <td>
                                <input disabled class="sigform-disabale block mt-1 w-full" wire:model="dept_head">
                            </td>
                        </tr>

                    </table>

                </div>
            </div>

            <div class="row sig-mar d-flex justify-content-center">
                <div class="col-md-5 text-center">
                    <div class=" mt-3 d-flex justify-content-center">
                        <input disabled class="text-center signform-open block mt-1 w-full" wire:model="preparedby">
                    </div>
                    <label class="mb-1  sign-text-open">Prepared by Head Department</label>
                    <div class=" p-1 d-flex justify-content-center">
                        <button wire:click="esign" class="ms-2 btn btn-sm btn-success mt-1" style="width: 70px; height: 29px;">Sign</button>
                        <button wire:click="clearesign" class="ms-2 btn btn-sm btn-secondary mt-1 me-2 " wire:loading.attr="disabled" style="width: 70px; height: 29px;">Clear</button>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <style>
        .txt-a {
            border-radius: 10px;
            border: 1px solid lightgray;
        }
    </style>

</div>