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
                        <option value="acc_code">Acc code</option>
                        <option value="description">Description</option>
                        <option value="reference">Reference</option>
                        <option value="class_code">Class code</option>
                        <option value="class_description">Class desc.</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head">
                        <th scope="col">Acc Code</th>
                        <th scope="col">Description</th>
                        <th scope="col">Reference</th>
                        <th scope="col">Class code</th>
                        <th scope="col">Class Description</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($acc))
                    @for($i =0; $i <= (count($acc)-1); $i++) <tr class="record" wire:click="show({{$acc[$i]->id}},{{$i}})">
                        <td>{{$acc[$i]->acc_code}}</td>
                        <td>{{$acc[$i]->description }}</td>
                        <td>{{$acc[$i]->reference}}</td>
                        <td>{{$acc[$i]->class_code}}</td>
                        <td>{{$acc[$i]->class_description}}</td>
                        </tr>
                        @endfor
                        @endif
                </tbody>
            </table>
            {{$acc->links()}}
        </div>


        @if(empty($acc))
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <!--  Modal -->
    <div wire:ignore.self class="modal fade" id="viewAcc" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header-->
                <div class="modal-header bg-modalheader">
                    <h5 class="modal-title h5">Account code<strong></strong> </h5>
                    <button class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Form-->
                <div class="modal-body">
                    <div class="row pe-3 ps-3 pb-3">


                        <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-lg-3 col-form-label">Account Code</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="first_name" disabled type="text" class="mt-1 block w-full" wire:model.defer="acc_code" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-lg-3 col-form-label">Description</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="last_name" disabled type="text" class="mt-1 block w-full" wire:model.defer="description" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Reference</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="position" disabled type="text" class="mt-1 block w-full" wire:model.defer="reference" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Class code</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="dept_code" disabled type="text" class="mt-1 block w-full" wire:model.defer="class_code" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Class description</label>
                            <div class="col-md-8 col-lg-9">
                                <x-jet-input id="email" type="email" disabled class="mt-1 block w-full" wire:model.defer="class_d" />
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
        window.addEventListener('showAcc', event => {
            $('#viewAcc').modal('show');
        });

        window.addEventListener('hideAcc', event => {
            $('#viewAcc').modal('hide');
        });
    </script>

</div><!-- End -->