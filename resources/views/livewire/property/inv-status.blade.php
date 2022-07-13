<div>
    <div class="row bg-white">

        <div class="col-md-3 bg-white  border">
            <div class="bg-light-gy p-3 border max-filter ">
                <div class="mb-2">
                    <x-jet-label for="skey" value="Search SubDept. code" />
                    <x-jet-input wire:model="search" id="search" class="block mt-1 w-full" type="search" />
                </div>
            </div>

            <!--FEA Numbers-->
            <div class="overflow-auto list-number bg-white max-filter p-2">


                <ul class="nav-parent list-group list-group-flush">
                    <ul class="dept-list nav-parent list-group list-group-flush">
                        @if(!empty($invlist))
                        @forelse($invlist as $iv)
                        <li id="{{$iv->subdept_code}}" wire:click="viewList('{{$iv->subdept_code}}')" class="list-group-item  d-flex justify-content-between align-items-center">
                            Sd: {{$iv->subdept_code}}


                            @if($iv->status == "Active")
                            <span class="badge  rounded-pill text-white" style="background-color: #2E8A88;">{{$iv->status}}</span>
                            @elseif($iv->status == "Ongoing")
                            <span class="badge  rounded-pill text-white" style="background-color: #64C3C1;">
                                Counting
                            </span>
                            @elseif($iv->status == "Done")
                            <span class="badge  rounded-pill text-white" style="background-color: #81B79C;">{{$iv->status}}</span>
                            @else
                            @endif

                        </li>
                        @empty
                        <p class="text-center mt-3">No transaction yet</p>
                        @endforelse
                        @endif
                    </ul>
            </div>
        </div>

        <div class="col-md-9 min-height-form mb-2" id="form-content">

            @if(empty($preview))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>

            <!--FORM-->
            @else
            <!--Header-->

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">
                <div style="height:auto;" class="max-form bg-dark-gy d-flex align-items-center justify-content-between p-2">
                    <div class="d-flex">
                        <div class=" align-content-center">
                            <x-jet-label for="skey" class="me-2  text-light" value="Status" />
                            <select class="form-select filter-record mt-1" wire:model="status" style="height: 40px">
                                <option selected value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Found">Found</option>
                                <option value="NotFound">NotFound</option>
                            </select>
                        </div>

                    </div>
                    <div>
                        <button class="btn btn-sm bg-secondary text-white" wire:click="clear">
                            X
                        </button>
                    </div>
                </div>
                <div class="row">
                    <!--Items Table-->
                    <div id="itemtable" class="mt-1">
                        <div class="col-md-12 overflow-auto">
                            <div class="col-md-12 table-responsive p-1">
                                <table class="table table-hover table-bordered">
                                    <thead class="text-center">
                                        <tr class="">
                                            <th scope="col">Status</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Property No.</th>
                                            <th scope="col">Serial No.</th>
                                            <th scope="col">Fea No.</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Unit Cost</th>
                                            <th scope="col">Subdept Code</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @if(!empty($ItemsInv))
                                        @forelse($ItemsInv as $iv)
                                        <tr>
                                            <td>
                                                @if($iv->status == 'Found')
                                                <label class="text-success">
                                                    Found<br>
                                                    <i class="bi bi-check2-square"></i>
                                                </label>
                                                @elseif($iv->status == 'Notfound')
                                                <label class="text-danger">
                                                    Not Found<br>
                                                    <i class="bi bi-file-excel"></i>
                                                </label>
                                                @else
                                                <label class="text-primary">
                                                    <i class="bi bi-search"></i>
                                                </label>
                                                @endif
                                            </td>
                                            <td>{{$iv->name}}<br>{{$iv->item_description}}</td>
                                            <td>{{$iv->property_number}}</td>
                                            <td>{{$iv->serial_number}}</td>
                                            <td>{{$iv->fea_number}}</td>
                                            <td>{{$iv->qty}}</td>
                                            <td>&#8369; {{$iv->amount}}</td>
                                            <td>{{$iv->subdept_code}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8">
                                                <div class="p-4 text-center" style="font-size: 20px;background-color: white;">
                                                    No item found<i class="bi bi-file-earmark-excel"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                        @endif
                                    </tbody>
                                </table>
                                <!-- End Table-->
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>