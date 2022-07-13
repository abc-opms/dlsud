<div>
    <div class="mt-4 card p-3">
        <!--CREATE NEW-->

        <div class="row d-flex justify-content-end mb-3">
            <div class="col-sm-6">
                <select class="mt-1 entries bg-light" wire:model="entries">
                    <option selected value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <label for="">entries per page</label>
            </div>

            <div class="col-sm-6 d-flex justify-content-end">
                <div class="d-flex">
                    <x-jet-input placeholder="Search..." id="search" class="block mt-1 w-full search-record" type="search " wire:model="search" />
                    <select class="form-select filter-record mt-1" wire:model="filterby">
                        <option value="rr_number">RR no.</option>
                        <option value="acc_code">Acc/ code</option>
                        <option value="item_description	">Item description</option>
                        <option value="acq_date">Acq date</option>
                    </select>
                </div>
            </div>
        </div>




        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head">
                        <th scope="col">Acc Code</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Item Description</th>
                        <th scope="col">Oum</th>
                        <th scope="col">Unit Cost</th>
                        <th scope="col">Amount</th>
                        <th scope="col">RR no.</th>
                        <th scope="col">Acq. Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($rritems))
                    @for($i =0; $i <= (count($rritems)-1); $i++) <tr class="record" wire:click="show({{$rritems[$i]->id}},{{$i}})">
                        <td>{{$rritems[$i]->acc_code}}</td>
                        <td>{{$rritems[$i]->delivery_qty}}</td>
                        <td>{{$rritems[$i]->item_description}}</td>
                        <td>{{$rritems[$i]->oum}}</td>
                        <td>{{$rritems[$i]->unit_cost}}</td>
                        <td>{{$rritems[$i]->amount}}</td>
                        <td>{{$rritems[$i]->rr_number}}</td>
                        <td>{{$rritems[$i]->acq_date}}</td>
                        </tr>
                        @endfor
                        @endif
                </tbody>
            </table>
            {{$rritems->links()}}
        </div>


        @if(empty($rritemsr))
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewRrItem" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header-->
                <div class="modal-header bg-modalheader">
                    <h5 class="modal-title h5">RR Item<strong></strong> </h5>
                    <button class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Form-->
                <div class="modal-body">
                    <div class="row pe-3 ps-3 pb-3">

                        <!-- First Name -->
                        <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-lg-3 col-form-label">Account Code</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="first_name" disabled type="text" class="mt-1 block w-full" wire:model.defer="acc_code" />
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-lg-3 col-form-label">Qty/OUM</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="last_name" disabled type="text" class="mt-1 block w-full" wire:model.defer="qty" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Item description</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="position" disabled type="text" class="mt-1 block w-full" wire:model.defer="item_d" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Unit Cost</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="dept_code" disabled type="text" class="mt-1 block w-full" wire:model.defer="unit_cost" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Amount</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="email" type="email" disabled class="mt-1 block w-full" wire:model.defer="amount" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">RR no.</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="email" type="email" disabled class="mt-1 block w-full" wire:model.defer="rrnum" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Acq. date</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="email" type="email" disabled class="mt-1 block w-full" wire:model.defer="acq_date" />
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Modal Buttons-->
                <div class="modal-footer ">
                    <button class="btn btn-secondary mt-2 me-3" wire:click="closeModal">Cancel</button>
                </div>
            </div>
        </div>
    </div><!-- End  Modal-->

    <script>
        window.addEventListener('showRrItem', event => {
            $('#viewRrItem').modal('show');
        });

        window.addEventListener('hideRrItem', event => {
            $('#viewRrItem').modal('hide');
        });
    </script>

</div><!-- End -->