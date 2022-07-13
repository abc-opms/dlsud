 <div>

     <!--Header-->
     <div class="bg-dark-gy max-form d-flex align-items-center justify-content-between p-2">
         <h1 class="h4">General Information</h1>
         <button class="btn btn-sm btn-secondary" wire:click="closeRR">
             {{ __('x') }}
         </button>

     </div>

     <div class="max-filter   bg-white p-3 ">
         <!-- HEADER DETAILS -->
         <div class="d-flex justify-content-between">
             <strong>
                 <h1>Requesting Department</h1>
             </strong>
             <button wire:click="preview" class="btn btn-sm btn-success btn-save p-2">FINALIZE</button>
         </div>

         <!-- Top Form -->
         <div class="row">
             <!--- SUPPLIER ID -->
             <div class="col-md-6 mt-3">
                 <div class="d-flex justify-content-between">
                     <x-jet-label for="s_id" value="{{ __('Supplier Name') }}" />
                     <a href="/records/Supplier" style="font-size: 14px; color:cadetblue;">
                         <strong>Add new supplier</strong>
                     </a>
                 </div>
                 <div class="d-flex">
                     <select class="form-select" aria-label="State" wire:model="supplier_code">
                         <option value="">--Select--</option>
                         @foreach($supp as $sup)
                         <option value="{{$sup->supplier_code}}">{{$sup->name}}</option>
                         @endforeach
                     </select>
                     @error('supplier_code')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- DELIVERY DATE -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="delivery_date" value="{{ __('Delivery Date') }}" />
                 <div class="d-flex">
                     <x-jet-input id="delivery_date" class="block mt-1 w-full" type="date" wire:model="delivery_date" />
                     @error('delivery_date')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- INVOICE / OR -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="invoice" value="{{ __('Invoice/OR') }}" />
                 <div class="d-flex">
                     <x-jet-input id="invoice" class="block mt-1 w-full" type="text" wire:model="invoice" />
                     @error('invoice')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- INVOICE DATE -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="invoice_date" value="{{ __('Invoice Date') }}" />
                 <div class="d-flex">
                     <x-jet-input id="invoice_date" class="block mt-1 w-full" type="date" wire:model="invoice_date" />
                     @error('invoice_date')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- PO NUMBER -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="ponum" value="{{ __('PO No.') }}" />
                 <div class="d-flex">
                     <x-jet-input id="ponum" class="block mt-1 w-full" type="text" wire:model="ponum" />
                     @error('ponum')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- Department -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="s_id" value="{{ __('Department Code') }}" />
                 <div class="d-flex">
                     <select class="form-select" aria-label="State" wire:model.lazy="dept_code">
                         <option value="">--Select--</option>
                         @foreach($department as $d)
                         <option value="{{$d->dept_code}}">{{$d->dept_code}}</option>
                         @endforeach
                     </select>
                     @error('dept_code')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- Received by -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="receivedby" value="{{ __('Received by') }}" />
                 <div class="d-flex">
                     <select class="form-select" aria-label="State" wire:model.lazy="receivedby">
                         <option value="">--Select--</option>
                         @foreach($custodian as $c)
                         <option value="{{$c->school_id}}">{{$c->last_name}}, {{$c->first_name}}</option>
                         @endforeach
                     </select>
                     @error('receivedby')<span class="error text-danger">*</span> @enderror
                 </div>
             </div>

             <!--- Total Amount -->
             <div class="col-md-6 mt-3">
                 <x-jet-label for="total" value="{{ __('Total') }}" />
                 <div class="d-flex">
                     <x-jet-input disabled id="total" class="block mt-1 w-full" type="text" wire:model="total" />
                 </div>
             </div>

             <!--- RECEIPT -->
             <div class="col-md-6 mt-3 ow mb-3">

                 <div class="d-flex justify-content-between">
                     <x-jet-label for="receipt" value="{{ __('Receipt') }}" />
                     @if (!empty($clickpreview))
                     <x-jet-label for="role" class="me-2 text-success">
                         <a data-bs-toggle="modal" id="rpreview" wire:click="showReceipt">Receipt Preview</a>
                     </x-jet-label>
                     @endif
                 </div>
                 @if(empty($updateRRnumPic))
                 <div class="d-flex">
                     <x-jet-input id="upload{{ $iteration}}" name="receiptimage" class=" mt-1 w-full p-2" type="file" wire:model="receipt" />
                     @error('receipt')<span class="error text-danger">*</span> @enderror
                 </div>
                 @else
                 <button class="btn btn-secondary btn-sm mt-1 w-full p-2" wire:click="changeReceipt">Change Receipt Image</button>
                 @endif
             </div>

             <!--- RECEIPT PREVIEW -->
             @if ($previewreceipt)
             <div class="col-md-12 ow mb-3 text-center">
                 @if ($previewreceipt)
                 <div class="d-flex justify-content-between">
                     <x-jet-label for="role" class="me-2 text-success">
                         <a data-bs-toggle="modal" id="rpreview" wire:click="closeReceipt">Close preview</a>
                     </x-jet-label>
                 </div>

                 @if(empty($updateRRnumPic))
                 <img src="{{ $receipt->temporaryUrl()}}" class="img-fluid" alt="Responsive image">
                 @else
                 <img src="/storage/receipt/{{$updateRRnumPic}}" class="img-fluid" alt="Responsive image">
                 @endif

                 @else
                 <H1>no image</H1>
                 @endif
             </div>
             @endif
             <!---END OF TOP FORM FIELDS---->
         </div>


         <!-- Items -->
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
                             @if(!empty($items))
                             @for($i=count($items)-1; $i >= 0; $i--) <tr>
                                 <td class="p-2" wire:click="showItemdata('{{$i}}')">{{$items[$i]['name']}}</td>
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
                         <button class="btn btn-danger btn-sm" wire:click="deleteItem({{$itemid}})"><i class="bi bi-trash"> Delete</i></button>
                         <button class="btn btn-secondary btn-sm" wire:click="clearItem"><i class="bi bi-backspace"> Cancel</i></button>
                         <button class="btn btn-info btn-sm" wire:click="updatesaveItems('{{$itemid}}')"></i> Update</button>
                     </div>
                     @else
                     <div>
                         <!--- BUTTON FOR ADD -->
                         <button class="btn btn-secondary btn-sm" wire:click="clearItem"><i class="bi bi-backspace"> Clear</i></button>
                         <button class="btn btn-success btn-sm" wire:click="saveItem"> <i class="bi bi-pencil"></i> Add </button>
                     </div>
                     @endif
                 </div>
                 <div class="row">


                     <!--- Name-->
                     <div class="col-md-6 mt-3">
                         <x-jet-label for="name" value="Name" />
                         <div class="d-flex">
                             <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" />
                             @error('name')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>


                     <!--- Acc Code -->
                     <div class="col-md-6 mt-3">
                         <x-jet-label for="acccode" value="{{ __('Acc. Code') }}" />
                         <div class="d-flex">
                             <select class="form-select mt-1" aria-label="State" wire:model="acc_code">
                                 <option selected>--Select--</option>
                                 @foreach($accounts as $c)
                                 <option value="{{$c->acc_code}}">{{$c->description}}</option>
                                 @endforeach
                             </select>
                             @error('acc_code')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>

                     <!--- ITEM -->
                     <div class="col-md-12 mt-3">
                         <x-jet-label for="item" value="{{ __('Item') }}" />
                         <div class="d-flex">
                             <x-jet-input id="item" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="item" />
                             @error('item')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>


                     <!--- OUM -->
                     <div class="col-md-6 mt-3">
                         <x-jet-label for="oum" value="{{ __('OUM') }}" />
                         <div class="d-flex">
                             <x-jet-input id="oum" class="block mt-1 w-full" type="text" wire:model="oum" />
                             @error('oum')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>

                     <!--- Order Qty -->
                     <div class="col-md-6 mt-3">
                         <x-jet-label for="orderqty" value="{{ __('Order Qty.') }}" />
                         <div class="d-flex">
                             <x-jet-input id="orderqty" class="block mt-1 w-full" type="number" wire:model="order_qty" />
                             @error('order_qty')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>

                     <!--- Unit Cost -->
                     <div class="col-md-6 mt-3">
                         <x-jet-label for="unitcost" value="{{ __('Unit Cost') }}" />
                         <div class="d-flex">
                             <x-jet-input id="unitcost" class="block mt-1 w-full" type="number" wire:model="unit_cost" />
                             @error('unit_cost')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>


                     <!--- DELIVERY DATE -->
                     <div class="col-md-6 mt-3">
                         <x-jet-label for="deliverqty" value="{{ __('Delivery Qty.') }}" />
                         <div class="d-flex">
                             <x-jet-input id="deliverqty" class="block mt-1 w-full" type="number" wire:model="deliver_qty" />
                             @error('deliver_qty')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>

                     <!--- Amount -->
                     <div class="col-md-6 mt-3">
                         <div class="d-flex justify-content-between">
                             <x-jet-label for="amount" value="{{ __('Amount') }}" />
                             <x-jet-label for="role" class="me-2 text-success">
                                 <a data-bs-toggle="modal" wire:click="updateAmount">
                                     Total</a>
                             </x-jet-label>
                         </div>
                         <div class="d-flex">
                             <x-jet-input id="amount" disabled class="block mt-1 w-full" type="number" wire:model="amount" />
                             @error('amount')<span class="error text-danger">*</span> @enderror
                         </div>
                     </div>

                     <div class="mt-5"></div>
                 </div>
             </div>
         </div>




         <!-- Signature -->
         <div class="row  mt-2 d-flex justify-content-center border">

             <div class="sign_container p-3  d-flex mb-3">
                 <div class="col-s mt-3 me-5">
                     <label class="mb-1  sig-text">Prepared by:</label><br>
                     <input disabled class="signform-open text-center block mt-1 w-full" wire:model="preparedby">
                     <div class=" p-1 d-flex justify-content-center">
                         <button wire:click="esign" class="ms-2 btn btn-sm btn-success mt-1" style="width: 70px; height: 29px;">Sign</button>
                         <button wire:click="clearesign" class="ms-2 btn btn-sm btn-secondary mt-1 me-2 " style="width: 70px; height: 29px;">Clear</button>
                     </div>
                 </div>

                 <div class="col-s mt-3">
                     <label class="mb-1  sig-text-disbale">Checked by:</label> <br>
                     <input disabled class="sigform-disabale text-center block mt-1 w-full" wire:model="checkedby">
                 </div>
             </div>
         </div>
     </div>




     <!--PREVIEW FINALIZE MODAL-->
     <div class="modal fade" id="previewFinalizeModalRR" tabindex="-1">
         <div class="modal-dialog modal-fullscreen">
             <div class="modal-content">
                 <div class="modal-header">
                     <h3 class="modal-title">Receiving Report</h3>
                     <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div>
                         <strong><label class="text-success">
                                 Please make sure that everything you enter here is correct because you will not be able to edit or delete this transaction once you submit it.
                             </label></strong>
                     </div>
                     <div class="row p-3">

                         <div class="col-lg-6">
                             <div class="row">
                                 <!--- SUPPLIER ID -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="sid" value="{{ __('Supplier Code')}}" />
                                     <x-jet-input disabled id="sid" class="block mt-1 w-full" type="text" wire:model="sid" />
                                 </div>

                                 <!--- SUPPLIER NAME -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="sname" value="{{ __('Supplier Name')}}" />
                                     <x-jet-input disabled id="sname" class="block mt-1 w-full" type="text" wire:model="sname" />
                                 </div>

                                 <!--- SUPPLIER ADDRESS -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="saddress" value="{{ __('Supplier Address')}}" />
                                     <x-jet-input disabled id="saddress" class="block mt-1 w-full" type="text" wire:model="saddress" />
                                 </div>

                                 <!--- Tel & Fax No -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="stelnum" value="{{ __('Tel & Fax No')}}" />
                                     <x-jet-input disabled id="stelnum" class="block mt-1 w-full" type="text" wire:model="stelnum" />
                                 </div>
                             </div>
                         </div>

                         <div class="col-lg-6">
                             <div class="row">
                                 <!--- DELIVERY DATE -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="r_ddate" value="{{ __('Delivery Date') }}" />
                                     <x-jet-input disabled id="delivery_date" class="block mt-1 w-full" type="text" wire:model="r_ddate" />
                                 </div>


                                 <!--- PO NUMBER -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="r_ponum" value="{{ __('PO No.') }}" />
                                     <x-jet-input disabled id="ponum" class="block mt-1 w-full" type="text" wire:model="r_ponum" />

                                 </div>

                                 <!--- INVOICE / OR -->
                                 <div class="col-md-6 d-flex">
                                     <div class="col-md-6 mt-3">
                                         <x-jet-label for="r_invoice" value="{{ __('Invoice/OR') }}" />
                                         <x-jet-input disabled id="invoice" class="block mt-1 w-full" type="text" wire:model="r_invoice" />
                                     </div>
                                     <!--- invoice DATE -->
                                     <div class="col-md-6 mt-3">
                                         <x-jet-label for="r_ddate" value="{{ __('Invoice Date') }}" />
                                         <x-jet-input disabled id="invoice_date" class="block mt-1 w-full" type="text" wire:model="r_idate" />
                                     </div>
                                 </div>

                                 <!--- Total -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="total" value="{{ __('Total') }}" />
                                     <x-jet-input disabled id="total" class="block mt-1 w-full" type="text" wire:model="total" />

                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-6">
                             <div class="row">
                                 <!--- Received by -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="total" value="{{ __('Received by') }}" />
                                     <x-jet-input disabled id="total" class="block mt-1 w-full" type="text" wire:model="rby" />

                                 </div>

                                 <!--- Sub dept -->
                                 <div class="col-md-6 mt-3">
                                     <x-jet-label for="total" value="Department" />
                                     <x-jet-input disabled id="total" class="block mt-1 w-full" type="text" wire:model="dept" />
                                 </div>
                             </div>
                         </div>
                     </div>

                     <!-- Start of Div Item Table -->
                     <div class="col-md-12 p-2 table-responsive mt-3">
                         <!-- Start of Item Table-->
                         <table class="table table-hover table-bordered">
                             <thead class="text-center">
                                 <tr>
                                     <th scope="col">Acc. Code</th>
                                     <th scope="col">Name</th>
                                     <th scope="col">Item description</th>
                                     <th scope="col">OUM</th>
                                     <th scope="col">Unit Cost</th>
                                     <th scope="col">Order Qty</th>
                                     <th scope="col">Deliver Qty</th>
                                     <th scope="col">Amount</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @if(!empty($ItemPreview))
                                 @foreach($ItemArray as $itemf)
                                 <tr>
                                     <td>{{$itemf['acc_code']}}</td>
                                     <td>{{$itemf['name']}}</td>
                                     <td>{{$itemf['item']}}</td>
                                     <td>{{$itemf['oum']}}</td>
                                     <td>&#8369; {{$itemf['unit_cost']}}</td>
                                     <td>{{$itemf['order_qty']}}</td>
                                     <td>{{$itemf['deliver_qty']}}</td>
                                     <td>&#8369; {{$itemf['amount']}}</td>
                                 </tr>
                                 @endforeach
                                 @endif
                             </tbody>
                         </table>
                         <!-- End Table-->
                     </div><!-- End od DIV Table -->
                     <!--- RECEIPT PREVIEW -->
                     @if (!empty($receipt))
                     <div class="col-md-10 ow mb-3 justify-content-center">
                         @if(!empty($receipt))
                         <img src="{{ $receipt->temporaryUrl()}}" class="img-fluid" alt="Responsive image">
                         @else
                         <H1>no image</H1>
                         @endif
                     </div>
                     @endif

                 </div>
                 <div class="modal-footer">
                     <x-jet-button data-bs-dismiss="modal" wire:click="saveRR" wire:loading.attr="disabled">
                         {{ __('Save') }}
                     </x-jet-button>
                     <x-jet-secondary-button data-bs-dismiss="modal" wire:loading.attr="disabled">
                         {{ __('Continue Editing') }}
                     </x-jet-secondary-button>
                 </div>
             </div>
         </div>
     </div>


     <!--  Modal -->
     <div wire:ignore.self class="modal fade" id="openRrForm" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header ">
                     <h5 class="modal-title">Close Transaction</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     Are you sure you want to close this transaction? This action cannot be undone.
                 </div>
                 <div class="modal-footer">
                     <x-jet-secondary-button class="ml-4 btn-sm" data-bs-dismiss="modal">
                         {{ __('Cancel') }}
                     </x-jet-secondary-button>
                     <x-jet-button class="ml-4 btn-sm" wire:click="yes">
                         {{ __('Yes') }}
                     </x-jet-button>
                 </div>
             </div>
         </div>
     </div>


 </div>