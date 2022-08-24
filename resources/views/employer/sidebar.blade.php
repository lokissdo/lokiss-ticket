
<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
  <div class="sidebar float-left ">
    
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white height-100" >
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Sidebar</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="{{route('serviceprovider.index')}}" class="nav-link {{$site=='index'?'active':'text-white'}}" aria-current="page">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
            Home
          </a>
        </li>
        <li>
          <a href="{{route('serviceprovider.index')}}" class="nav-link {{$site=='dashboard'?'active':'text-white'}}">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            Dashboard
          </a>
        </li>
        <li>
          <a href="{{route('serviceprovider.schedule.index')}}" class="nav-link {{$site=='schedule'?'active':'text-white'}}">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
           Schedules
          </a>
        </li>
        <li>
          <a href="{{route('serviceprovider.trip.index')}}" class="nav-link {{$site=='trip'?'active':'text-white'}}">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            Trips
          </a>
        </li>
        <li>
          <a href="{{route('serviceprovider.coach.index')}}" class="nav-link {{$site=='coach'?'active':'text-white'}}">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
            Coaches
          </a>
        </li>
        
        <li>
          <a href="{{route('employer.employee.index')}}" class="nav-link {{$site=='employee'?'active':'text-white'}}">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
            Employees
          </a>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{session('user')['avatar']??asset('img/user.png')}}" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong>{{session('user')['name']}}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="{{route('signOut')}}">
            Sign out
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
              <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
          </a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="sidebar-overlay "></div>

 