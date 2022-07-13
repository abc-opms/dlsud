<x-app-layout>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            <h1>Content</h1>


            <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
            <script>
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('220d4f577c9e175dfbba', {
                    cluster: 'ap1'
                });

                var channel = pusher.subscribe('my-channel');
                channel.bind('my-event', function(data) {
                    alert(JSON.stringify(data));
                    Livewire.emit('postAdded');
                });
            </script>

            <h1 id="demo"></h1>






        </section>
    </main><!-- End #main -->
</x-app-layout>