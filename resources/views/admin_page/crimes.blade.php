<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <a class="nav-link active" href="/crime_dash">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Crime Management
                        </a>
                        <a class="nav-link" href="/crime_chart">
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
                    <h1 class="mt-4">Crime Reports</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Crime Dashboard</li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol>

                    <!-- Crime Data Table -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Confirmed Crime
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="display">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Address</th>
                                        <th>Location</th>
                                        <th>Reported By</th>
                                        <th>Approved By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Address</th>
                                        <th>Location</th>
                                        <th>Reported By</th>
                                        <th>Approved By</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($crimes as $crime)
                                        <tr>
                                            <td>{{ $crime->crime_type}}</td>
                                            <td>{{ $crime->description }}</td>
                                            <td>{{ $crime->date }}</td>
                                            <td>{{ $crime->created_at }}</td>
                                            <td>{{ $crime->address }}</td>
                                            <td>{{ $crime->latitude }}, {{ $crime->longitude }}</td>
                                            <td>{{ optional($crime->reportedBy)->name }}</td>
                                            <td>{{ optional($crime->approvedBy)->admin_username }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCrimeModal{{ $crime->id }}">Edit</button>
                                                <form action="/delete_crime/{{ $crime->id }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this crime?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Crime Modal -->
                                        <div class="modal fade" id="editCrimeModal{{ $crime->id }}" tabindex="-1"
                                            aria-labelledby="editCrimeModalLabel{{ $crime->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editCrimeModalLabel{{ $crime->id }}">
                                                            Edit Crime</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editCrimeForm{{ $crime->id }}"
                                                            action="{{ route('crimes.update', $crime->id) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" id="crime_id" name="crime_id"
                                                                value="{{ $crime->id }}">
                                                            <div class="mb-3">
                                                                <label for="crime_type{{ $crime->id }}"
                                                                    class="form-label">Crime Type:</label>
                                                                <select class="form-select" id="crime_type{{ $crime->id }}"
                                                                    name="crime_type"
                                                                    onchange="toggleOtherInput({{ $crime->id }})">
                                                                    <option disabled selected>{{ $crime->crime_type }}
                                                                    </option>
                                                                    <option value="Burglary">Burglary</option>
                                                                    <option value="Cyber Fraud">Cyber Fraud</option>
                                                                    <option value="Identity Theft">Identity Theft</option>
                                                                    <option value="Vandalism">Vandalism</option>
                                                                    <option value="Shoplifting">Shoplifting</option>
                                                                    <option value="Embezzlement">Embezzlement</option>
                                                                    <option value="Drug Possession">Drug Possession</option>
                                                                    <option value="Drunk Driving">Drunk Driving</option>
                                                                    <option value="Domestic Violence">Domestic Violence
                                                                    </option>
                                                                    <option value="Robbery">Robbery</option>
                                                                    <option value="Art Theft">Art Theft</option>
                                                                    <option value="other">Other (Specify)</option>
                                                                </select>
                                                                <div id="other_crime_input{{ $crime->id }}"
                                                                    style="display: none;" class="mt-2">
                                                                    <label for="other_crime_description{{ $crime->id }}"
                                                                        class="block text-sm font-bold leading-6 text-black">Describe
                                                                        the Crime:</label>
                                                                    <input type="text"
                                                                        id="other_crime_description{{ $crime->id }}"
                                                                        name="other_crime_description"
                                                                        class="block w-full rounded-md border border-gray-300 bg-blue-100 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400 sm:text-sm sm:leading-6">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description{{ $crime->id }}"
                                                                    class="form-label">Description:</label>
                                                                <input type="text" class="form-control"
                                                                    id="description{{ $crime->id }}" name="description"
                                                                    value="{{ $crime->description }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="date{{ $crime->id }}"
                                                                    class="form-label">Date:</label>
                                                                <input type="date" class="form-control"
                                                                    id="date{{ $crime->id }}" name="date"
                                                                    value="{{ $crime->date }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="time{{ $crime->id }}"
                                                                    class="form-label">Time:</label>
                                                                <input type="time" class="form-control"
                                                                    id="time{{ $crime->id }}" name="time"
                                                                    value="{{ $crime->time }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="address{{ $crime->id }}"
                                                                    class="form-label">Address:</label>
                                                                <input type="text" class="form-control"
                                                                    id="address{{ $crime->id }}" name="address"
                                                                    value="{{ $crime->address }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="latitude{{ $crime->id }}"
                                                                    class="form-label">Latitude:</label>
                                                                <input type="text" class="form-control"
                                                                    id="latitude{{ $crime->id }}" name="latitude"
                                                                    value="{{ $crime->latitude }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="longitude{{ $crime->id }}"
                                                                    class="form-label">Longitude:</label>
                                                                <input type="text" class="form-control"
                                                                    id="longitude{{ $crime->id }}" name="longitude"
                                                                    value="{{ $crime->longitude }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple.js"></script>
    <script src="js/toggle.js"></script>
</body>

</html>