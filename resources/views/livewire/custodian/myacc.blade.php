<div>
    <div class="mt-4 card p-3">
        <!--CREATE NEW-->
        <div class="row d-flex justify-content-between mb-3">
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
                        <option selected value="property_code">Property No.</option>
                        <option value="acq_date">Acq. Date</option>
                        <option value="item_name">Item Description</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table record-table">
                <thead>
                    <tr class="record-head ">
                        <th scope="col">Property No.</th>
                        <th scope="col">Serial No.</th>
                        <th scope="col">Item Description</th>
                        <th scope="col">Acq. Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i)
                    <tr>
                        <td>{{$i->property_code}}</td>
                        <td>{{$i->serial_number}}</td>
                        <td>
                            {{$i->name}}
                            <p style="font-size: 12px;">{{$i->item_description}}</p>
                        </td>
                        <td>{{$i->acq_date}}</td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        {{$items->links()}}

        @if(count($items) == 0)
        <div class="p-2 text-center">
            <label for="">No data available</label>
        </div>
        @endif
    </div>


    <style>
        .entries {
            border-radius: 10px;
            border: 1px solid lightgrey;
        }
    </style>
</div><!-- End -->