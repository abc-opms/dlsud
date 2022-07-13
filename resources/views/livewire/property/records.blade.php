<div>
    <div class="row">

        <!--Filter-->
        <div class="col-md-6 mt-3">
            <label for="skey" class="me-3">Filter Category</label>
            <select class="form-select btn-light filtersearch " wire:model="filterCategory">
                <option value="logs">Select</option>
                <option value="Acc-Code">Account Code</option>
                <option value="Department">Department</option>
                <option value="Rr-Items">Items</option>
                <option value="Sub-Department">Sub Department</option>
                <option value="Signupkey">Signup Key</option>
                <option value="Supplier">Supplier</option>
                <option value="User">User</option>
            </select>

        </div>

        @if($filterCategory=="Signupkey")
        @livewire('records.signupkeys')

        @elseif($filterCategory=="Rr-Items")
        @livewire('records.rritems')

        @elseif($filterCategory=="Acc-Code")
        @livewire('records.acc-code')

        @elseif($filterCategory=="Supplier")
        @livewire('records.supplier')

        @elseif($filterCategory=="User")
        @livewire('records.custodian')


        @elseif($filterCategory=="Department")
        @livewire('records.department')


        @elseif($filterCategory=="Sub-Department")
        @livewire('records.sub-department')
        @endif
    </div>
</div>