<div>
    <div class="row bg-white" id="form-content">

        <div class="d-flex justify-content-end">

            <select class="form-select-v mt-1" wire:model="inv_year" wire:loading.attr="disabled" style="height: 40px">
                @forelse($year as $y)
                <option value="{{$y->year}}">Current {{$y->year}}</option>
                @empty
                -
                @endforelse
            </select>
        </div>

        <div class="mt-3">

            <div class="card">
                <div class="card-body">
                    <div class="row mt-2 p-2 mb-3 d-flex justify-content-between align-content-center">
                        <h5 class="col-sm-6 card-title">Inventory List ({{$inv_year}} - {{$inv_year+1}})</h5>
                        <div class="d-flex justify-content-end col-sm-6">
                            <x-jet-input wire:model.debounce.500ms="search" placeholder="Search.." style="height:40px; width:300px" id="supplier" class=" block mt-1 w-full text-dark" type="search" />
                            <select class="form-select filter-record mt-1" wire:model="filterby" wire:loading.attr="disabled" style="height: 40px">
                                <option value="property_number">Property No.</option>
                                <option value="name">Name</option>
                                <option value="status">Status</option>
                                <option value="fea_number">Fea No.</option>
                            </select>
                        </div>
                    </div>


                    <div class="overflow-auto">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Inv #</th>
                                    <th>Property No.</th>
                                    <th>Qty</th>
                                    <th>Item Description</th>
                                    <th>Serial No.</th>
                                    <th>Unit Cost</th>
                                    <th>Fea No.</th>
                                    <th>Acq. Date</th>
                                    <th>Subdept Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($inv_main))
                                @forelse($inv_main as $i)
                                <tr wire:loading.class.delay="opacity-50">
                                    <td>{{$i->inv_number}}</td>
                                    <td>{{$i->property_number}}</td>
                                    <td>{{$i->qty}}</td>
                                    <td>{{$i->name}} {{$i->item_description}}</td>
                                    <td>@if(!empty($i->serial_number))
                                        {{$i->serial_number}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{$i->amount}}</td>
                                    <td>{{$i->fea_number}}</td>
                                    <td>{{$i->acq_date}}</td>
                                    <td>{{$i->subdept_code}}</td>
                                    <td>{{$i->status}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="p-4 text-center" style="font-size: 20px;background-color: white;">
                                            No item found <i class="bi bi-file-earmark-excel"></i>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                                @endif
                        </table>
                    </div>
                    {{$inv_main->links()}}
                </div>
            </div>

        </div>

    </div>


    <style>
        .form-search {
            min-width: 400px;
            max-width: 800px;
            line-height: 1;
            border: solid 1px gray;
            border-radius: 7px;
            height: 40px;
        }

        .form-select-v {
            width: 200px;
            padding: 5px;
            font-size: 17px;
            line-height: 1;
            border: solid 1px gray;
            border-radius: 7px;
            height: 40px;
        }
    </style>
</div>