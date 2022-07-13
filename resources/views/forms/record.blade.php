<x-app-layout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Records</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/records/logs">Home</a></li>
                    <li class="breadcrumb-item"><a href="/records/logs">Records</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            @if(Auth::user()->hasRole('Property'))
            @livewire('property.records', ['id' => $id])

            @else
            @livewire('warehouse.records', ['id' => $id])
            @endif

        </section>
    </main><!-- End #main -->
</x-app-layout>