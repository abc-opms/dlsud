<div>
    <div class="row bg-white">
        <!--STARRRRRRRRRRRRRRRRRRRRRTTTTTTTTTTTTTT-->
        <div class="col-md-3 bg-white  border">

            <div class="mb-2 mt-3">
                <x-jet-label for="skey" value="Select form type" />
                <select class="form-select  block mt-1 w-full" wire:model="formType" wire:loading.attr="disabled">
                    <option value="">--Select--</option>
                    <option value="rdf">RDF</option>
                    <option value="rtf">RTF</option>
                    <option value="rrqf">RRQF</option>
                    <option value="fea">FEA</option>
                    <option value="inventory">INVENTORY</option>
                </select>
            </div>

            @if(!empty($formType))
            <hr class="mt-4">

            <div class="mb-2 mt-3 ">
                <x-jet-label for="skey" value="Select Date" />
                <select class="form-select  block mt-1 w-full" wire:model="dateVal" wire:loading.attr="disabled">
                    <option value="">--Select--</option>
                    <option value="range">Range</option>
                    <option value="all">All Data</option>
                </select>
            </div>
            @endif

            {{$show}}

            @if(!empty($dateVal))
            @if($dateVal == 'range')
            @if($formType != 'inventory')
            <div class="mt-4">
                <x-jet-label for="skey" value="Enter Date Range:" />
                <div class="d-flex mt-3">
                    <x-jet-label for="skey" value="From: " class="mt-3" />
                    <input wire:model="from_date" class="mt-1 block mt-1 w-full report-input" type="date" />
                </div>
                <div class="d-flex mt-3">
                    <x-jet-label for="skey" value="To: " class="mt-3 me-2" />
                    <input wire:model="to_date" class="mt-1 block mt-1 w-full report-input" type="date" />
                </div>

            </div>

            @else

            <div class="mt-4">
                <x-jet-label for="skey" value="Enter Year Range:" />
                <div class="d-flex mt-3">
                    <x-jet-label for="skey" value="From: " class="mt-3" />
                    <select name="from" id="from" class="select-year mt-1 block mt-1 w-full">
                        @foreach($yearRange as $y)
                        <option value="">{{$y}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex mt-3">
                    <x-jet-label for="skey" value="To: " class="mt-3 me-2" />
                    <select name="from" id="from" class="select-year mt-1 block mt-1 w-full">
                        @foreach($yearRange as $y)
                        <option value="">{{$y}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            @endif

            <div class="d-flex justify-content-center mt-5">
                <x-jet-button wire:click="search" wire:loading.attr="disabled" class="mt-3" style="background-color: #168A3F;">
                    Search
                </x-jet-button>
            </div>

            @elseif($dateVal == 'all')
            <div class="d-flex justify-content-center mt-5">
                <x-jet-button wire:click="allS" wire:loading.attr="disabled" class="mt-3" style="background-color: #14909A;">
                    Search All
                </x-jet-button>
            </div>
            @endif
            @endif
        </div>
        <!--ENDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD-->



        <div class="col-md-9 min-height-form" id="form-content">
            @if(empty($openForm))
            <div class="d-flex align-items-center justify-content-center max-height">
                <h1><strong>Choose a transaction</strong></h1>
            </div>

            <!--FORM-->
            @else


            <!--Header-->
            <div class="max-form d-flex align-items-center justify-content-between p-2">
                <h1>General Information</h1>

                <button class="btn btn-sm btn-secondary" wire:click="clearAll">
                    {{ __('x') }}
                </button>
            </div>


            @if($formType == 'rdf')
            <!--RDF-->
            <div class="d-flex justify-content-between p-1 row mt-4">
                <div class="d-flex col-md-4 p-1">
                    <x-jet-button class="bg-success" wire:click="RDFpdf">
                        Export PDF
                    </x-jet-button>
                </div>
                <div class="d-flex col-md-8">
                    @if(!empty($filterByRdf))
                    <x-jet-input wire:model="searchRdf" id="search" class="block mt-1 w-full" type="search" />
                    @endif
                    <select class="form-select mt-1" aria-label="State" wire:model="filterByRdf">
                        <option value="subdept_code">Subdept Code</option>
                        <option value="rdf_number">RDF No.</option>
                        <option value="checked_date">Created Date</option>
                        <option value="recorded_date">Date Recorded</option>
                    </select>
                </div>
            </div>

            <!--TABLE-->
            <div class="col-md-12 ">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">RDF No.</th>
                            <th scope="col">No. of Items</th>
                            <th scope="col">Req Dept Code</th>
                            <th scope="col">Date Requested</th>
                            <th scope="col">Date Recorded</th>
                            <th scope="col">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($feaVals))
                        @foreach($feaVals as $fe)
                        <tr>
                            <th scope="row">{{$fe['rdf_number']}}</th>
                            <th>{{$fe['numItem']}}</th>
                            <th>{{$fe['subdept']}}</th>
                            <th>{{$fe['date_created']}}</th>
                            <th>{{$fe['date_recorded']}}</th>
                            <th>{{$fe['duration']}}</th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>


            @elseif($formType == 'rtf')
            @elseif($formType == 'fea')
            <!--FEA-->
            <div class="d-flex justify-content-between p-1 row mt-4">
                <div class="d-flex col-md-4 p-1">
                    <x-jet-button class="bg-success" wire:click="FEApdf">
                        Export PDF
                    </x-jet-button>
                </div>
                <div class="d-flex col-md-8">
                    @if(!empty($filterBy))
                    <x-jet-input wire:model="search" id="search" class="block mt-1 w-full" type="search" />
                    @endif
                    <select class="form-select mt-1" aria-label="State" wire:model="filterBy">
                        <option value="subdept_code">Subdept Code</option>
                        <option value="fea_number">FEA No.</option>
                        <option value="checked_date">Created Date</option>
                        <option value="recorded_date">Date Recorded</option>
                    </select>
                </div>
            </div>

            <!--TABLE-->
            <div class="col-md-12 ">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fea No.</th>
                            <th scope="col">No. of Items</th>
                            <th scope="col">Req Dept Code</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Recorded</th>
                            <th scope="col">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($feaVals))
                        @foreach($feaVals as $fe)
                        <tr>
                            <th scope="row">{{$fe['fea_number']}}</th>
                            <th>{{$fe['numItem']}}</th>
                            <th>{{$fe['subdept']}}</th>
                            <th>{{$fe['total_amount']}}</th>
                            <th>{{$fe['date_created']}}</th>
                            <th>{{$fe['date_recorded']}}</th>
                            <th>{{$fe['duration']}}</th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @elseif($formType == 'inventory')
            <!--Inventory-->

            @else
            <!--Hello ELSE-->

            @endif

















            @if(!empty($MainTotal))
            <div class="total-r d-flex justify-content-end">
                <label for="">Total: </label>
                <label class="ms-2"><strong>&#8369; {{$MainTotal}}</strong></label>
            </div>
            @endif
            @endif
        </div>

        <!--ENDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD-->

        <style>
            .report-input {
                border-bottom: 1px solid black;
                border-top: none;
                border-left: none;
                border-right: none;
                font-size: 13px;
            }

            .select-year {
                border-top: none;
                border-left: none;
                border-right: none;
            }

            .checkbox-all {
                border-color: gray;
            }
        </style>
        <!--ENDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD-->
    </div>
</div>