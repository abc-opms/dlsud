<aside id="sidebar" class="sidebar">

    <!-- Logo -->
    <div class="d-flex justify-content-center mt-3 mb-2">
        <a href="/">
            @include('logo.sidebarlogo')
        </a>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">


        <li class="side-b nav-item ">
            <a class=" nav-link collapsed" href="/records/logs" id="records">
                <i class="bi bi-folder"></i>
                <span>Records</span>
            </a>
        </li><!-- End Records Nav -->

        
        @if(Auth::user()->hasRole('Property'))
        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/create/fea/logs" id="fea">
                <i class="bi bi-file-earmark-post"></i>
                <span>FEA</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/generate/qrretagging/logs" id="qrretagging">
                <i class="bi bi-qr-code"></i>
                <span>QR Retagging</span>
            </a>
        </li><!-- End QR Tagging Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/p/itemdisposal/sign/logs" id="itemdisposal">
                <i class="bi bi-recycle"></i>
                <span>Item Disposal</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/rtf/sign/logs" id="rtf">
                <i class="bi bi-arrows-move"></i>
                <span>Item Transfer</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/inventories/monitor/logs" id="inventories">
                <i class="bi bi-card-checklist"></i>
                <span>Inventories</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/generate/reports" id="reports">
                <i class="bi bi-newspaper"></i>
                <span>Reports</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @endif



        @if(Auth::user()->hasRole('Custodian'))
        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/c/receivingreport/sign/logs" id="receivingreport">
                <i class="bi bi-receipt"></i>
                <span>Receiving Report</span>
            </a>
        </li><!-- End Receiving Report Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/c/fea/sign/logs" id="fea">
                <i class="bi bi-journals"></i>
                <span>FEA</span>
            </a>
        </li><!-- End FEA Nav -->

        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/c/qrretagging/logs" id="qrretagging">
                <i class="bi bi-qr-code"></i>
                <span>QR Retagging</span>
            </a>
        </li><!-- End QR Tagging Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/myaccountabilities" id="accountabilities">
                <i class="bi bi-card-checklist"></i>
                <span>Accountabilities</span>
            </a>
        </li><!-- End Accountabilities Nav -->

        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/c/itemdisposal/logs" id="itemdisposal">
                <i class="bi bi-recycle"></i>
                <span>Item Disposal</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/c/rtf/sign/logs" id="rtf">
                <i class="bi bi-arrows-move"></i>
                <span>Item Transfer</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/c/inventories/logs" id="inventories">
                <i class="bi bi-card-checklist"></i>
                <span>Inventories</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @endif



        @if(Auth::user()->hasRole('Finance'))
        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/f/itemdisposal/sign/logs" id="itemdisposal">
                <i class="bi bi-recycle"></i>
                <span>Item Disposal</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/f/rtf/sign/logs" id="rtf">
                <i class="bi bi-arrows-move"></i>
                <span>Item Transfer</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @endif



        @if(Auth::user()->hasRole('Warehouse'))
        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/receivingreport/sign/logs" id="receivingreport">
                <i class="bi bi-receipt"></i>
                <span>Receiving Report</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="side-b nav-item ">
            <a class="nav-link collapsed" href="/itemdisposal/logs" id="itemdisposal">
                <i class="bi bi-recycle"></i>
                <span>Item Disposal</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @endif

        <!------------------FOR ALL THE USERS---------------------------- ------------------------------>


        <!-- Profile Page Nav -->
        <li class="side-b nav-heading">Pages</li>

        <li class=" side-b nav-item">
            <a class="nav-link collapsed" href="/user/profile" id="profile">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>


        <!-- Setting Nav -->
        <li class="side-b nav-item">
            <a class="nav-link collapsed" href="/setting" id="setting">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>


    </ul>

</aside><!-- End Sidebar-->