<div>
    <div class="row bg-white">
        <div class="col-md-12 min-height-form mb-2" id="form-content">

            <!--Header-->
            <div class="max-form d-flex align-items-center justify-content-between p-2">
                <h1>Create inventory list by department</h1>

                <button class="btn btn-sm btn-secondary" wire:click="clear">
                    {{ __('x') }}
                </button>
            </div>
            <div class="row ">
                @if(!empty($dept))
                @if(count($dept) != 0)
                <div class="mt-3 text-center">
                    <x-jet-label for="skey" value="Add all department you want to make a list." />
                </div>

                <div class="col-md-12 mt-3">

                    <div class="d-flex justify-content-center">

                        <select wire:model="d_values" class="form-select btn-light filtersearch block mt-1 w-full" style="max-width:600px;">
                            <option value="">--select---</option>
                            @foreach($dept as $d)
                            <option value="{{$d->subdept_code}},{{$d->description}},{{$d->dept_code}}">{{$d->description}}</option>
                            @endforeach
                        </select>
                        <x-jet-button wire:click="add" class="ms-2" style="height:45px;">
                            Add
                        </x-jet-button>

                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4 mb-3">
                    <hr class="col-md-12">
                </div>

                @if(!empty($deptlist))
                <div class="mb-3 d-flex justify-content-center">
                    <x-jet-button wire:click="createINV" class="bg-success mt-1 ms-2" style="height:40px;">
                        Create inventory
                    </x-jet-button>
                </div>
                @endif

                <div class="d-flex justify-content-center">
                    <table class="table table-striped" style="width: 90%;">
                        <thead>
                            <tr>
                                <th>
                                    Department
                                </th>
                                <th class="text-center">
                                    Dept. code
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!empty($deptlist))
                            @for($i=0; $i< count($deptlist); $i++) <tr>
                                <td>{{$deptlist[$i]['description']}}</td>
                                <td class="text-center">{{$deptlist[$i]['dept_code']}}</td>
                                <td class="text-center">
                                    <x-jet-danger-button wire:click="delete({{$i}})" class="mt-1 ms-2" style="height:30px;">
                                        Remove
                                    </x-jet-danger-button>
                                </td>
                                </tr>
                                @endfor
                                @endif
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center p-4">
                    <strong>
                        <label for="skey">All department have inventories.</label>
                    </strong>
                </div>
                @endif
                @endif
            </div>
        </div>




    </div>
</div>