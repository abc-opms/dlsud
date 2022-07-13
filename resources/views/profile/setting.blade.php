<x-app-layout>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Settings</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active"><a href="/setting">Settings</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">


            <div class="col-md-12 d-flex justify-content-center">
                <div class="cc">
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    @livewire('profile.two-factor-authentication-form')
                    @endif
                </div>
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <div class="cc">
                    @livewire('profile.logout-other-browser-sessions-form')

                </div>
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <div class="cc terms">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Terms and Condition') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('') }}
                        </x-slot>

                        <x-slot name="content">
                            <p>
                                Welcome to Online Property Management System owned and operated by De La Salle University – Dasmariñas (The University). By Accessing and using OPMS, you agree to be bound by the terms and conditions set forth below. If you do not agree to by bound by this Agreement, do not understand the Agreement, or if You need more time to review and consider this Agreement, please leave OPMS immediately. The University only agrees to provide use of OPMS and its Services to You if assent to this Agreement.
                            </p>

                            <label class="subtitle">DEFINITIONS</label>

                            <p>The parties referred to in this Agreement shall be defined as follows...
                                <span class="span"><a href="/terms-of-service" target="blank">See more</a></span>
                            </p>
                        </x-slot>
                    </x-jet-action-section>
                </div>
            </div>


            <div class="col-md-12 d-flex justify-content-center">
                <div class="cc terms">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Privacy Policy') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('') }}
                        </x-slot>

                        <x-slot name="content">
                            <p>
                                OPMS (We, Our, or Us) is committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by OPMS. This Privacy Policy applies to our web application, OPMS, and its associated subdomains (collectively, Our Services) alongside Our mobile application, OPMS Mobile. By accessing or using Our Services, you signify that you read, understood, and agree to Our collection, storage, use, and disclosure of your personal information as described in this Privacy Policy and Terms and Conditions.
                            </p>

                            <label class="subtitle">DEFINITIONS</label>

                            <p style="margin-left: 8px;">
                                a. University: when this policy mentions University, We, Us, or Our, it ...
                                <span class="span"><a href="/privacy-policy" target="blank">See more</a></span>
                            </p>
                        </x-slot>
                    </x-jet-action-section>
                </div>
            </div>





            <style>
                .cc {
                    max-width: 900px;
                }

                .subtitle {
                    font-weight: 700;
                    margin-top: 30px;
                }

                .span {
                    font-weight: 600;
                    color: #328447;
                }

                .span :hover {
                    font-weight: 600;
                    color: #7CB189;
                }
            </style>
        </section>

    </main><!-- End #main -->
</x-app-layout>