<div>

    <a class="nav-link nav-icon a-notif" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        @if($unread_count != 0)
        <span class="badge bg-light badge-number text-success" id="notif">
            {{$unread_count}}
        </span>
        @endif
    </a><!-- End Notification Icon -->

    <ul class=" dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header" style="max-width: 400px; min-width: 300px;">
            <div class="d-flex justify-content-between">
                <label style="font-weight: 600; font-size:16px">NOTIFICATIONS</label>
                <a href="#">
                    <i class="bi bi-three-dots"></i>
                </a>
            </div>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        @foreach($content as $c)
        <a href="{{$c->data['link']}}">
            <li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div>
                    <h4>
                        {{$c->data['title']}}
                    </h4>
                    <p>{{$c->data['message']}}</p>
                    <p>
                        {{$c->created_at->diffForHumans(null,true,true,2)}} ago
                    </p>
                </div>
            </li>
        </a>
        @endforeach

        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
        </li>

    </ul><!-- End Notification Dropdown Items -->
</div>