<header class="header">
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-primary shadow">
        <a class="sidebar-toggler text-white me-4 me-lg-5 lead" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <a class="navbar-brand fw-bold text-uppercase text-white text-base" href="{{ route('dashboard') }}">
            <span class="d-none d-brand-partial">COTAVOGA</span>
            <span class="d-none d-sm-inline">Management System</span>
        </a>
        <ul class="ms-auto d-flex align-items-center list-unstyled mb-0">
            <!-- Notifications Icon -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link text-white" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
                    <div class="dropdown-header text-dark">
                        <h6 class="text-uppercase font-weight-bold">Notifications</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">New user registration</a>
                    <a class="dropdown-item" href="#">Server downtime</a>
                    <a class="dropdown-item" href="#">Password change request</a>
                </div>
            </li>

            <!-- User Info Dropdown -->
            <!-- User Info Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" id="userInfo" href="#" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img class="avatar rounded-circle" alt="User Avatar"
                        src="{{ isset(auth()->user()->user_image)
                            ? url('storage/uploads/' . auth()->user()->user_image)
                            : asset('assests/image/default.png') }}">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="userInfo">
                    <div class="dropdown-header text-dark">
                        <h6 class="text-uppercase font-weight-bold">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#profileModal">Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Help</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">Logout</a>
                </div>
            </li>



        </ul>
    </nav>
</header>

<style>
    .navbar {
        border-radius: 0.5rem;
    }

    .sidebar-toggler {
        background-color: #155a8a;
        border-radius: 0.25rem;
        padding: 0.5rem;
        transition: background-color 0.3s ease;
    }

    .sidebar-toggler:hover {
        background-color: #103f61;
    }

    .navbar-brand {
        font-size: 1.25rem;
    }

    .navbar-brand span {
        color: #ffffff;
    }

    .avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    .dropdown-menu {
        min-width: 200px;
    }

    .dropdown-menu-animated {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item:hover {
        background-color: #e9ecef;
    }
</style>

<!-- Profile Update Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="user_image" class="form-label">Profile Image (optional)</label>
                        <input type="file" class="form-control" id="user_image" name="user_image">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
