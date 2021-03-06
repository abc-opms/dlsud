<x-app-layout>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/user/profile">User</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle">
                            <h2>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h2>
                            <h3>{{Auth::user()->position}} in {{Auth::user()->dept_code}}</h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Change Signature</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                </li>
                            </ul>


                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    @livewire('profile.overview')

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                    @livewire('profile.update-profile-information-form')
                                    @endif
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-settings">

                                    <div>
                                        @livewire('profile.changesig')
                                    </div>

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">

                                    @livewire('profile.update-password-form')
                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>


    </main><!-- End #main -->
</x-app-layout>