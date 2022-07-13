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
                                    <table class="table table-hover table-bordered" wire:loading.attr="disabled">
                                        <thead class="text-center">
                                            <tr class="">
                                                <th scope="col">RQR No.</th>
                                                <th scope="col">Reason</th>
                                                <th scope="col">Req. Dept Code</th>
                                                <th scope="col">Req. Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @if(!empty($rqr))
                                            @foreach($rqr as $r)
                                            <tr id="{{$r->rqr_number}}">
                                                <td>{{$r->rqr_number}}</td>
                                                <td>{{$r->reason}}</td>
                                                <td>{{$r->reqby}}</td>
                                                <td>{{$r->req_date}}</td>
                                                <td>{{$r->status}}</td>
                                                <td>
                                                    <x-jet-button wire:click="downloadQR('{{$r->rqr_number}}')" wire:loading.attr="disabled" class="bg-success">
                                                        Download QR
                                                    </x-jet-button>
                                                    <br>
                                                    <div class="qr" wire:loading wire:target="downloadQR('{{$r->rqr_number}}')">
                                                        downloading...
                                                    </div>
                                                </td>
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
                </div>

            </div>

        </div>
    </div>
</div>