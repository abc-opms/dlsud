<div>
    <div class="row bg-white">
        <div class="col-md-12 min-height-form" id="form-content">
            <div>
                <div style="background-color: #D3D3D3;height:70px;" class="max-form d-flex align-items-center justify-content-between p-2">
                    <div class="d-flex col-md-6 p-2 align-content-center">
                        <x-jet-label for="skey" class="me-2 mt-3" value="Search" />
                        <x-jet-input wire:model="search" id="search" class="text-dark block mt-1 w-full" type="search" />
                        <select class="form-select filter-record mt-1" wire:model="filterby">
                            <option value="qrtaggings.rqr_number">Rqr No.</option>
                            <option selected value="qrtaggings.req_date">Req. Dept Code</option>
                            <option value="qr_items.item">Item</option>
                            <option value="qr_items.item_status">Status</option>
                        </select>
                    </div>
                </div>


                <!-- ITEMS -->

                <div>
                    <div class="row">
                        <!--Items Table-->
                        <div id="itemtable" class="mt-1">
                            <div class="col-md-12 overflow-auto" style="max-height: 500px;">
                                <div class="col-md-12 table-responsive p-1">
                                    <table class="table table-hover table-bordered">
                                        <thead class="text-center">
                                            <tr class="">
                                                <th scope="col">RQR No.</th>
                                                <th scope="col">Property No.</th>
                                                <th scope="col">Item</th>
                                                <th scope="col">Reason</th>
                                                <th scope="col">Req. Dept Code</th>
                                                <th scope="col">Req. Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Approved By</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @if(!empty($rqr))
                                            @foreach($rqr as $r)
                                            <tr>
                                                <td>
                                                    {{$r->rqr_number}}
                                                </td>
                                                <td>
                                                    {{$r->property_number}}
                                                </td>
                                                <td>
                                                    {{$r->item}}
                                                </td>
                                                <td>
                                                    {{$r->reason}}
                                                </td>
                                                <td>
                                                    {{$r->subdept_code}}
                                                </td>
                                                <td>
                                                    {{$r->req_date}}
                                                </td>
                                                <td>
                                                    {{$r->item_status}}
                                                </td>
                                                <td>
                                                    {{$r->generatedby}}
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                    @if(empty($rqr))
                                    <div class="text-center">
                                        <label for=""> No request</label>
                                    </div>
                                    @endif
                                    <!-- End Table-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>