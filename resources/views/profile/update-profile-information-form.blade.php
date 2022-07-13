<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
            <div class="col-md-8 col-lg-9">
                <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                    <!-- Profile Photo File Input -->
                    <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>


                    <div class="pt-2">
                        <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                            <strong><i class="bi bi-upload"></i></strong>
                        </x-jet-secondary-button>

                        @if ($this->user->profile_photo_path)
                        <x-jet-danger-button type="button" class="mt-2 bg-danger" wire:click="deleteProfilePhoto">
                            <i class="bi bi-trash"></i>
                        </x-jet-danger-button>
                        @endif
                    </div>
                    <x-jet-input-error for="photo" class="mt-2" />
                </div>
            </div>
            @endif
        </div>


        <!-- First Name -->
        <div class="row mb-3">
            <label for="first_name" class="col-md-4 col-lg-3 col-form-label">First Name</label>
            <div class="col-md-8 col-lg-9">
                <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name" autocomplete="first_name" />
                <x-jet-input-error for="first_name" class="mt-2" />
            </div>
        </div>

        <!-- Last Name -->
        <div class="row mb-3">
            <label for="last_name" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
            <div class="col-md-8 col-lg-9">
                <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
                <x-jet-input-error for="last_name" class="mt-2" />
            </div>
        </div>

        <div class="row mb-3">
            <label for="about" class="col-md-4 col-lg-3 col-form-label">Position</label>
            <div class="col-md-8 col-lg-9">
                <x-jet-input id="position" type="text" class="mt-1 block w-full" wire:model.defer="state.position" autocomplete="position" />
                <x-jet-input-error for="position" class="mt-2" />
            </div>
        </div>

        <div class="row mb-3">
            <label for="company" class="col-md-4 col-lg-3 col-form-label">Dept. Code</label>
            <div class="col-md-8 col-lg-9">
                <x-jet-input id="dept_code" type="text" class="mt-1 block w-full" wire:model.defer="state.dept_code" autocomplete="dept_code" />
                <x-jet-input-error for="dept_code" class="mt-2" />
            </div>
        </div>

        <div class="row mb-3">
            <label for="company" class="col-md-4 col-lg-3 col-form-label">Sub dept. Code</label>
            <div class="col-md-8 col-lg-9">
                <x-jet-input id="subdept_code" type="text" class="mt-1 block w-full" wire:model.defer="state.subdept_code" autocomplete="dept_code" />
                <x-jet-input-error for="subdept_code" class="mt-2" />
            </div>
        </div>

        <div class="row mb-3">
            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Email</label>
            <div class="col-md-8 col-lg-9">
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
        </div>

    </x-slot>

    <x-slot name="actions">
        <div class="mt-2 d-flex flex-row-reverse">
            <x-jet-button wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save Changes') }}
            </x-jet-button>
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

        </div>
    </x-slot>
</x-jet-form-section>