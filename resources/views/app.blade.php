<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <title>@yield('title')</title>
</head>
<body>

<nav>
  <ul class="navigation">
    <li class="navigation-item">
      <a href="#">
        <div class="icon-container">
          <i class="fas fa-cube"></i>
        </div>
        <span>Items</span>
      </a>
      <ul class="dropdown">
        <li>
          <a href="#" class="dropdown-item">
            <div class="icon-container">
             <i class="fas fa-plus"></i>
            </div>
            <span>Add Item</span>
          </a>
        </li>
        <li>
          <a href="#" class="dropdown-item">
            <div class="icon-container">
             <i class="fas fa-edit"></i>
            </div>
            <span>Edit Item</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="navigation-item">
      <a href="#">
        <div class="icon-container">
          <i class="fas fa-users"></i>
        </div>
        <span>Users</span>
      </a>
      <ul class="dropdown">
        <li>
          <a href="#" class="dropdown-item">
            <div class="icon-container">
             <i class="fas fa-user-plus"></i>
            </div>
            <span>Add User</span>
          </a>
        </li>
        <li>
          <a href="#" class="dropdown-item">
            <div class="icon-container">
             <i class="fas fa-user-edit"></i>
            </div>
            <span>Edit User</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="navigation-item">
      <a href="#">
        <div class="icon-container">
          <i class="fas fa-dolly-flatbed"></i>
        </div>
        <span>Check-Out</span>
      </a>
    </li>
    <li class="navigation-item">
      <a href="#">
        <div class="icon-container">
          <i class="fas fa-arrow-left"></i>
        </div>
        <span>Check-In</span>
      </a>
    </li>
    <li class="navigation-item">
      <a href="#">
        <div class="icon-container">
          <i class="fas fa-search"></i>
        </div>
        <span>Search</span>
      </a>
    </li>
  </ul>
</nav>


@yield('content')
    
@yield('scripts')
</body>
</html>