<div>
    <div class="row bg-white" id="form-content">

        <div class="d-flex justify-content-end">

            <select class="form-select-v mt-1" wire:model="inv_year" style="height: 40px">
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
                    </div>
                    {{$show}}
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <a wire:click="download({{$inv_main}}, {{$total}})">
                                <x-jet-button class="bg-success">Export PDF</x-jet-button>
                            </a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-end">
                            <x-jet-input wire:model.debounce.500ms="search" placeholder="Search.." style="height:40px;" id="supplier" class=" block mt-1 w-full text-dark" type="search" />
                            <select class="mt-1 form-select-f" wire:model="filterby" style="height: 40px">
                                <option value="subdept">Subdept Code</option>
                                <option value="inv_num">Inventory No.</option>
                                <option value="property_number">Property No.</option>
                                <option value="serial_number">Serial No.</option>
                                <option value="fea_number">Fea No.</option>
                                <option value="acq_date">Acq. Date</option>
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
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="p-4 text-center" style="font-size: 20px;background-color: white;">
                                            No item found <i class="bi bi-file-earmark-excel"></i>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                                @endif
                        </table>
                    </div>
                    <div class="border d-flex justify-content-end p-2">
                        <label class="total">Total: &#8369;
                            <strong>{{$total}}</strong>
                        </label>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <style>
        .total {
            font-size: 20px;
        }

        .form-search {
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

        .form-select-f {
            font-size: 15px;
            line-height: 1;
            border: solid 1px lightgray;
            border-radius: 7px;
            height: 40px;
        }
    </style>
</div>