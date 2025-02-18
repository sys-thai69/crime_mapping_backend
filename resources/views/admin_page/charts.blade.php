<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Charts - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- Header Nav -->
    @include('admin_layout/headnav')
    
    <div id="layoutSidenav">
         <!-- Side Nav -->
         <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Data Management</div>
                        <a class="nav-link" href="/homepage">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Home
                        </a>
                        <a class="nav-link" href="/user_dash">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                            User Management
                        </a>
                        <a class="nav-link" href="/crime_dash">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Crime Management
                        </a>
                        <a class="nav-link active" href="/crime_chart">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i>
                            </div>
                            Crime Chart
                        </a>
                        <a class="nav-link" href="/addcrimetype">
                            <div class="sb-nav-link-icon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            </div>
                            Add Crime Types
                        </a>
                        <a class="nav-link" href="/pending_report">
                            <div class="sb-nav-link-icon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            </div>
                            Pending Report
                        </a>
                        <a class="nav-link" href="/crime_map">
                            <div class="sb-nav-link-icon"><i class="fas fa-map-marker-alt"></i>
                            </div>
                            Crime Map
                        </a>
                        <a class="nav-link" href="/contacts">
                            <div class="sb-nav-link-icon"><i class="fas fa-comments"></i>
                            </div>
                            Contact Feedbacks
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{$admin->admin_username}}
                </div>
            </nav>
        </div>

        <!-- Content Section -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Crime Charts</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Crime Diagrams</li>
                        <li class="breadcrumb-item active">Charts</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Yearly Incidents
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="140%" height="20"></canvas></div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Yearly Incidents
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Yearly Incidents
                                </div>
                                <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area.js"></script>
    <script src="assets/demo/chart-bar.js"></script>
    <script src="assets/demo/chart-pie.js"></script>
</body>

</html>