<div>

    <!--Header-->
    <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
        <h1 class="h4">General Information</h1>
        <button class="btn btn-sm btn-secondary" wire:click="clear">
            {{ __('x') }}
        </button>

    </div>

    <div class="max-filter   bg-white p-3 ">
        <!-- HEADER DETAILS -->
        <div class="d-flex justify-content-between">
            <strong>
                <h1>Requesting Department</h1>
            </strong>
            <button wire:click="saveRDF" wire:loading.attr="disabled" class="btn btn-sm btn-success btn-save p-2">
                SAVE TRANSACTION
            </button>
        </div>

        <!-- Top Form -->
        <div class="row">

            <!--- REASON -->
            <div class="col-md-8 mt-3">
                <x-jet-label for="reason" value="Reason" />
                <div class="d-flex">
                    <textarea id="reason" rows="2" cols="50" class="txt-a block mt-1 w-full" type="text" wire:model="reason"> </textarea>
                    @error('reason')<span class="error text-danger">*</span> @enderror
                </div>
            </div>

            <div class="col-md-4 mt-3">
                <x-jet-label for="reason" value="Evaluated by" />
                <div class="d-flex">
                    <select class="form-select mt-1" @if(!empty($evalSelect)) disabled @endif aria-label="State" wire:model="eval_by">
                        <option value="">--Select--</option>
                        <option value="BFMO">BFMO</option>
                        <option value="ICTC">ICTC</option>
                    </select>
                    @if(empty($evalSelect))
                    <button class="btn btn-sm bg-success text-light mt-1 ms-1" wire:click="saveEval" wire:loading.attr="disabled">Save</button>
                    @endif
                </div>

                @if(!empty($evalSelect))
                <button class="btn btn-sm bg-warning mt-1 ms-1" data-bs-toggle="modal" data-bs-target="#modalChangeEval">Change</button>
                @endif
            </div>
        </div>

        <hr class="mt-3 mb-3">

        <!-- Items -->
        @if(!empty($evalSelect))
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
                            @for($i=0; $i <= count($vals)-1; $i++)<tr class="itemSelect">
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
                        <x-jet-button class="bg-success btn-sm" wire:click="saveItem" wire:loading.attr="disabled"> <i class="bi bi-pencil"></i> Add </x-jet-button>
                    </div>
                    @endif
                </div>
                <div class="row">

                    <div class="col-md-12 row">
                        <!--- Property Code -->
                        <div class="col-md-6 mt-3">
                            <div class="d-flex justify-content-between">
                                <x-jet-label for="prty" value="Property No." />
                                @if(empty($sdata))
                                <button wire:click="find" class="btn btn-sm bg-warning">
                                    <strong>
                                        Find
                                    </strong>
                                </button>
                                @endif
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


        <!-- Signature -->
        <div class="row mt-2 d-flex justify-content-center border">
            <div class="col-md-5 text-center">
                <div class=" mt-3 d-flex justify-content-center">
                    <input disabled class="text-center signform-open block mt-1 w-full" wire:model="preparedby">
                </div>
                <label class="mb-1  sign-text-open">Prepared by Head Department</label>
                <div class=" p-1 d-flex justify-content-center">
                    <button wire:click="esign" class="ms-2 btn btn-sm btn-success mt-1" style="width: 70px; height: 29px;">Sign</button>
                    <button wire:click="clearesign" class="ms-2 btn btn-sm btn-secondary mt-1 me-2 " style="width: 70px; height: 29px;">Clear</button>
                </div>
            </div>
        </div>
        @endif

    </div>

    <style>
        .txt-a {
            border-radius: 10px;
            border: 1px solid lightgray;
        }
    </style>



    <div class="modal fade" id="modalChangeEval" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Evaluated by</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">
                        Are you sure you want to change the evaluated by?
                        If you change, all the items you added will be removed.
                    </label>
                </div>
                <div class="modal-footer">
                    <x-jet-secondary-button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</x-jet-secondary-button>
                    <x-jet-button class="btn btn-primary" wire:click="changeEval" wire:loading.attr="disabled">Save changes</x-jet-button>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>




</div>