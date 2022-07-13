<x-app-layout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>@yield('title')</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/records/logs">Home</a></li>
                    @yield('breadcrumb')

                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            @yield('content')


        </section>
    </main>
</x-app-layout>