<!-- Sidebar Toggle Button for Mobile -->
<button class="sidebar-toggle" id="sidebar-toggle">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar bg-light" id="sidebar">
    <ul class="list-unstyled mb-5">
        {{-- Dashboard --}}
        <li class="sidebar-list-item py-3"><a class="sidebar-link text-muted active" href="{{ route('dashboard') }}">
                <i class="fas fa-home me-2 text-info"></i>
                <span class="sidebar-link-title fs-6">Dashboards</span></a>
        </li>

        {{-- User Profile --}}
        <li class="sidebar-list-item py-2"><a class="sidebar-link text-muted" href="{{ route('profile') }}">
                <i class="fa-regular fa-user me-2 text-info"></i>
                <span class="sidebar-link-title fs-6">Profile</span></a>
        </li>
        {{-- Manage Member --}}
        @if (auth()->user()->role === 'admin')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#account" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-users me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Account Status</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="account">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.account') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Bank Acount
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        {{-- Manage Member --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'secretary' || auth()->user()->role === 'accountant')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#widgetsDropdown" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-users me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Member</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="widgetsDropdown">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.department') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Guardians
                        </a>
                    </li>
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.member') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Members
                        </a>
                    </li>
                </ul>
            </li>
        @endif



        {{-- Manage Share --}}
        @if (auth()->user()->role === 'admin')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#share" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-chart-pie me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Share</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="share">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.share') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Share
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        {{-- Manage Loan --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'secretary')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#componentsDropdown" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-dollar-sign me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Loan</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="componentsDropdown">
                        <li class="sidebar-list-item py-2 fs-6">
                            <a class="sidebar-link text-muted ms-4" href="{{ route('loan.loanForm') }}">
                                <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Apply Loan
                            </a>
                        </li>
                 

                    {{-- Shown to both accountant and secretary --}}
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('leave.myLeave') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>My Loan
                        </a>
                    </li>

                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('loan.loanStatus') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Loan Request
                        </a>
                    </li>

                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('loan.paymentHistory') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Payment history
                        </a>
                    </li>

                </ul>
            </li>
        @endif


           {{-- Manage Loan --}}
           {{-- @if (auth()->user()->role === 'secretary') --}}
           {{-- <li class="sidebar-list-item py-2">
               <a class="sidebar-link text-muted" href="#" data-bs-target="#componentsDropdown" role="button"
                   aria-expanded="false" data-bs-toggle="collapse">
                   <i class="fa-solid fa-dollar-sign me-2 text-info"></i>
                   <span class="sidebar-link-title fs-6">Manage Loan</span></a>
               <ul class="sidebar-menu list-unstyled collapse" id="componentsDropdown">
                       <li class="sidebar-list-item py-2 fs-6">
                           <a class="sidebar-link text-muted ms-4" href="{{ route('loan.loanForm') }}">
                               <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Apply Loan
                           </a>
                       </li> --}}
                   {{-- Shown to both accountant and secretary --}}
                   {{-- <li class="sidebar-list-item py-2 fs-6">
                       <a class="sidebar-link text-muted ms-4" href="{{ route('leave.myLeave') }}">
                           <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>My Loan
                       </a>
                   </li>

                   <li class="sidebar-list-item py-2 fs-6">
                       <a class="sidebar-link text-muted ms-4" href="{{ route('loan.loanStatus') }}">
                           <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Loan Request
                       </a>
                   </li>

                   <li class="sidebar-list-item py-2 fs-6">
                       <a class="sidebar-link text-muted ms-4" href="{{ route('loan.paymentHistory') }}">
                           <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Payment history
                       </a>
                   </li> --}}
               {{-- </ul> --}}
           </li>
           {{-- @endif --}}

              {{-- Manage Loan --}}
              @if (auth()->user()->role === 'member'||auth()->user()->role === 'acountant')
              <li class="sidebar-list-item py-2">
                  <a class="sidebar-link text-muted" href="#" data-bs-target="#componentsDropdown" role="button"
                      aria-expanded="false" data-bs-toggle="collapse">
                      <i class="fa-solid fa-dollar-sign me-2 text-info"></i>
                      <span class="sidebar-link-title fs-6">Manage Loan</span></a>
                  <ul class="sidebar-menu list-unstyled collapse" id="componentsDropdown">
                          <li class="sidebar-list-item py-2 fs-6">
                              <a class="sidebar-link text-muted ms-4" href="{{ route('loan.loanForm') }}">
                                  <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Apply Loan
                              </a>
                          </li>
                      <li class="sidebar-list-item py-2 fs-6">
                          <a class="sidebar-link text-muted ms-4" href="{{ route('leave.myLeave') }}">
                              <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>My Loan
                          </a>
                      </li>
                 
                  </ul>
              </li>
          @endif
   












       {{-- Manage Property --}}
@if (auth()->user()->role === 'admin' || auth()->user()->role === 'accountant')
<li class="sidebar-list-item py-2">
    <a class="sidebar-link text-muted" href="#" data-bs-target="#property" role="button"
        aria-expanded="false" data-bs-toggle="collapse">
        <i class="fa-solid fa-building me-2 text-info"></i>
        <span class="sidebar-link-title fs-6">Manage Property</span>
    </a>
    <ul class="sidebar-menu list-unstyled collapse" id="property">
        <li class="sidebar-list-item py-2 fs-6">
            <a class="sidebar-link text-muted ms-4" href="{{ route('organization.properties') }}">
                <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Property
            </a>
        </li>
    </ul>
</li>
@endif


        {{-- Manage Meeting --}}
        @if (auth()->user()->role === 'admin')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#meeting" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-handshake me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Meeting</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="meeting">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.meeting') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Meeting
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- Manage Punishment --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'acountant')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#punishment" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-gavel me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Punishment</span>
                </a>
                <ul class="sidebar-menu list-unstyled collapse" id="punishment">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.punishment') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Punishment
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        {{-- Manage Punishment --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'acountant')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#parking" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-gavel me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Parking</span>
                </a>
                <ul class="sidebar-menu list-unstyled collapse" id="parking">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.parking') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Parking
                        </a>
                    </li>
                </ul>
            </li>
        @endif




        {{-- Manage Expenditure --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'acountant')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#expenduture" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-wallet me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Manage Expenditure</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="expenduture">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.expenduture') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Expenditure
                        </a>
                    </li>
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4"
                            href="{{ route('organization.expendutureCategory') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Category
                        </a>
                    </li>
                </ul>
            </li>
        @endif



        {{-- Manage Expenditure --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'acountant')
            <li class="sidebar-list-item py-2">
                <a class="sidebar-link text-muted" href="#" data-bs-target="#service" role="button"
                    aria-expanded="false" data-bs-toggle="collapse">
                    <i class="fa-solid fa-wallet me-2 text-info"></i>
                    <span class="sidebar-link-title fs-6">Services</span></a>
                <ul class="sidebar-menu list-unstyled collapse" id="service">
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.irembo') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Irembo
                        </a>
                    </li>
                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.bank') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Bank
                        </a>

                    <li class="sidebar-list-item py-2 fs-6">
                        <a class="sidebar-link text-muted ms-4" href="{{ route('organization.mobile') }}">
                            <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>MOMO/AIRTEL
                        </a>
                    </li>
                    {{-- <li class="sidebar-list-item py-2 fs-6">
                    <a class="sidebar-link text-muted ms-4" href="{{ route('organization.expendutureCategory') }}">
                        <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Category
                    </a>
                </li> --}}
                </ul>
            </li>
        @endif
























        {{-- Manage Agents --}}
        {{-- <li class="sidebar-list-item py-2">
            <a class="sidebar-link text-muted" href="#" data-bs-target="#agent" role="button" aria-expanded="false" data-bs-toggle="collapse">
                <i class="fa-solid fa-handshake me-2 text-info"></i>
                <span class="sidebar-link-title fs-6">Manage Agents</span></a>
            <ul class="sidebar-menu list-unstyled collapse" id="agent">
                <li class="sidebar-list-item py-2 fs-6">
                    <a class="sidebar-link text-muted ms-4" href="{{ route('organization.agent') }}">
                        <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Agents
                    </a>
                </li>
                <li class="sidebar-list-item py-2 fs-6">
                    <a class="sidebar-link text-muted ms-4" href="{{ route('organization.agentProfit') }}">
                        <i class="fa-regular fa-circle-right fa-sm me-1 text-info"></i>Profit
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
    <hr class="mb-0">
</div>


<style>
    .sidebar {
        width: 250px;
        padding: 20px;
        transition: all 0.3s;
    }

    .sidebar-list-item a {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        transition: background-color 0.3s ease;
    }

    .sidebar-list-item a:hover {
        background-color: #f1f1f1;
    }

    .sidebar-link-title {
        flex-grow: 1;
    }

    .sidebar-link-title,
    .sidebar-link i {
        font-size: 1rem;
    }

    .sidebar hr {
        border-top: 1px solid #eaeaea;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            position: fixed;
            left: -100%;
            top: 0;
            height: 100%;
            z-index: 1000;
            overflow-y: auto;
            background: #fff;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar hr {
            display: none;
        }
    }

    /* Sidebar Toggle Button */
    .sidebar-toggle {
        display: none;
        background: #007bff;
        color: #fff;
        border-radius: 50%;
        padding: 10px;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: block;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
        }
    }
</style>
