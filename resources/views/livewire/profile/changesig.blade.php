<div>
    <div class="col-md-12 p-3">
        <label for="">Signature</label>
        @if(empty($esig))
        <img src="/storage/esigs/{{Auth::user()->signature_path}}" alt="esig" class="sig-pr">
        <x-jet-button wire:click="changes" class="bg-info">Change</x-jet-button>
        @endif
    </div>

    @if(!empty($esig))
    <div class="col-md-12 p-3">
        <x-jet-input id="val" class="block mt-1 bg-light" type="file" wire:model="val" />
        @error('val')<p class="error text-danger mt-1">{{$message}}</p> @enderror
    </div>


    <div class="col-md-12 d-flex justify-content-end mb-3">
        <x-jet-secondary-button wire:click="cancel" class="bg-info">Cancel</x-jet-secondary-button>
        <x-jet-button wire:click="save" class="ms-3 me-3">Save</x-jet-button>
    </div>
    @endif



    <style>
        .sig-pr {
            width: 200px;
        }
    </style>
</div>