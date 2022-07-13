<x-app-layout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Accountabilities</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/records/logs">Accountabilities</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            @livewire('custodian.myacc')
        </section>
    </main><!-- End #main -->
</x-app-layout>