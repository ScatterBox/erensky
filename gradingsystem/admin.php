<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<?php include 'hui.php' ?>
<?php include 'adduser.php'; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/datatables.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

<link rel="stylesheet" href="styles.css" />

<body>
    <div class="header">
    <div class="header__left">
        <img src="logo.jpg" alt="" />
        <h3>Admin Dashboard</h3>
    </div>

    <div class="header__middle">
        <div class="header__option" onclick="showFaculty()">
            <span class="material-icons"> group </span>
        </div>
        <div class="header__option" onclick="showAdmin()">
            <span class="material-icons"> group </span>
        </div>
        <div class="header__option" onclick="showManageClass()">
            <span class="material-icons"> group </span>
        </div>
    </div>

    <div class="header__right">
        <div class="header__info">
            <img class="user__avatar" src="<?php echo $_SESSION['user']['img']; ?>" alt="" />
            <h4><?php echo $_SESSION['user']['nickname']; ?></h4>
        </div>
        <div class="dropdown">
            <span class="material-icons dropdown-toggle" id="addDropdown" data-bs-toggle="dropdown" aria-expanded="false"> add </span>
            <ul class="dropdown-menu" aria-labelledby="addDropdown">
                <li><a class="dropdown-item" href="#" onclick="showAddUser()">Add Student</a></li>
                <li><a class="dropdown-item" href="#" onclick="showNewTeacher()">Add Teacher</a></li>
                <li><a class="dropdown-item" href="#" onclick="showNewAdmin()">Add Admin</a></li>
            </ul>
        </div>
        <span class="material-icons" onclick="logout()"> logout </span>
    </div>
</div>

<!-- Main content -->
<div class="container" id="mainContent">
    <!-- Content will be dynamically loaded here -->
</div>

    <footer>
        <h4>FLORENTINO GALANG SR. NATIONAL HIGH SCHOOL GRADING SYSTEM</h4>
    </footer>



    <script>
        function showAddOptions() {
            // Implement logic to display options (e.g., a dropdown menu)
            // You can use CSS to show/hide the relevant elements.
            console.log("Showing add options: Add Student, Teacher, Admin");
            // Add your specific logic here...
        }
        function logout() {
            // Your logout logic here (e.g., redirect to logout page)
            window.location.href = "logout.php";
        }

        //List of Admins//
        function showAdmin() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `
            <style>
                h1 {
                    margin-top: 20px;
                }
            </style>
        <h1 style="text-align: center;">List of Admins</h1>
        <table id="adminTable" class="table table-striped smaller-table" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Age</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    `;

            // Fetch the admin data from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_admins.php', true);
            xhr.onload = function () {
                if (this.status == 200) {
                    // Parse the JSON data
                    var admins = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#adminTable tbody');

                    // Insert the admin data into the table
                    for (var i = 0; i < admins.length; i++) {
                        var tr = document.createElement('tr');
                        var fullname = `${admins[i].fname} ${admins[i].mname} ${admins[i].lname} ${admins[i].ename}`;
                        tr.innerHTML = `
                    <th scope="row">${i + 1}</th>
                    <td>${fullname}</td>
                    <td>${admins[i].age}</td>
                    <td>${admins[i].address}</td>
                    <td>${admins[i].gender}</td>
                `;
                        tbody.appendChild(tr);
                    }

                    // Initialize DataTable
                    $('#adminTable').DataTable();
                }
            };
            xhr.send();
        }

        // Ensure the function is called to render the admin table
        document.addEventListener('DOMContentLoaded', showAdmin);

        //Add Teacher//
        function showNewTeacher() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `  <?php include 'conn.php'; ?>
            <style>
                h3 {
                    margin-top: 20px;
                }
            </style>
            <h3>Teacher Submitter Form</h3>
            <div class="registration-form">
    <form id="teacherForm">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control item" id="fname" name="fname" placeholder="Example: Juan" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="mname">Middle Name:</label>
                    <input type="text" class="form-control item" id="mname" name="mname" placeholder="Example: Dela" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control item" id="lname" name="lname" placeholder="Example: Crunchy" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ename">Extension Name:</label>
                    <input type="text" class="form-control item" id="ename" name="ename" placeholder="Example: Sr.">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nickname">Nickname:</label>
                    <input type="text" class="form-control item" id="nickname" name="nickname" placeholder="Example: Tutu" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control item" id="age" name="age" placeholder="Example: 12" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select class="form-control item" id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" class="form-control item" id="birthdate" name="birthdate" placeholder="Example: 01/01/2001" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control item" id="address" name="address" placeholder="Example: Purok. Pinetree, Brgy. Oringao, Kabankalan City, Negros Occidental." required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control item" id="username" name="username" placeholder="Example: @JuanFGSNHS" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control item" id="password" name="password" placeholder="" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <input type="text" class="form-control item" id="role" name="role" value="teacher" readonly>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="img">Profile Image URL:</label>
                    <input type="text" class="form-control item" id="img" name="img" placeholder="Example: juan.jpg" required>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </div>
        </div>
    </form>
</div>

    `;
            // Get the form element
            var form = document.getElementById('teacherForm');

            // Attach a submit event handler to the form
            form.addEventListener('submit', function (event) {
                // Prevent the form from being submitted normally
                event.preventDefault();

                // Create a new FormData object from the form
                var formData = new FormData(form);

                // Use AJAX to submit the form data
                var request = new XMLHttpRequest();
                request.open('POST', 'tdbconn.php');
                request.onreadystatechange = function () {
                    if (request.readyState === 4 && request.status === 200) {
                        // The request has completed successfully
                        var response = JSON.parse(request.responseText);
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            );
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }

                        // Reset the form fields
                        form.reset();
                    }
                };
                request.send(formData);
            });
        }


        //Add Admin//
        function showNewAdmin() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = ` <?php include 'conn.php'; ?> 
            <style>
                h3 {
                    margin-top: 20px;
                }
            </style>
            <h3>Admin Submitter Form</h3>
    <div class="registration-form">
        <form id="adminForm">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" class="form-control item" id="fname" name="fname" placeholder="Example: Juan" required>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name:</label>
                <input type="text" class="form-control item" id="mname" name="mname" placeholder="Example: Dela" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" class="form-control item" id="lname" name="lname" placeholder="Example: Crunchy" required>
            </div>
            <div class="form-group">
                <label for="ename">Extension Name:</label>
                <input type="text" class="form-control item" id="ename" name="ename" placeholder="Example: Sr.">
            </div>
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" class="form-control item" id="nickname" name="nickname" placeholder="Example: Tutu" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" class="form-control item" id="age" name="age" placeholder="Example: 12" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control item" id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" class="form-control item" id="birthdate" name="birthdate" placeholder="Example: 01/01/2001" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control item" id="address" name="address" placeholder="Example: Purok. Pinetree, Brgy. Oringao, Kabankalan City, Negros Occidental." required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control item" id="username" name="username" placeholder="Example: @JuanFGSNHS" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control item" id="password" name="password" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" class="form-control item" id="role" name="role" value="Admin" readonly>
            </div>
            <div class="form-group">
                <label for="img">Profile Image Filename:</label>
                <input type="text" class="form-control item" id="img" name="img" placeholder="Example: juan.jpg">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
        </form>
    </div>
    `;
            // Get the form element
            var form = document.getElementById('adminForm');

            // Attach a submit event handler to the form
            form.addEventListener('submit', function (event) {
                // Prevent the form from being submitted normally
                event.preventDefault();

                // Create a new FormData object from the form
                var formData = new FormData(form);

                // Use AJAX to submit the form data
                var request = new XMLHttpRequest();
                request.open('POST', 'adbconn.php');
                request.onreadystatechange = function () {
                    if (request.readyState === 4 && request.status === 200) {
                        // The request has completed successfully
                        var response = JSON.parse(request.responseText);
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            );
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }

                        // Reset the form fields
                        form.reset();
                    }
                };
                request.send(formData);
            });
        }



        //Add Student//
        function showAddUser() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = ` <?php include 'conn.php'; ?>
            <style>
                h3 {
                    margin-top: 20px;
                }
            </style>
            <h3>Student Submitter Form</h3> 
            <div class="registration-form">
    <form action="submit.php" method="post" id="studentForm">
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" class="form-control item" id="fname" name="fname" placeholder="Example: Juan" required>
        </div>
        <div class="form-group">
            <label for="mname">Middle Name:</label>
            <input type="text" class="form-control item" id="mname" name="mname" placeholder="Example: Dela" required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" class="form-control item" id="lname" name="lname" placeholder="Example: Crunchy" required>
        </div>
        <div class="form-group">
            <label for="ename">Extension Name:</label>
            <input type="text" class="form-control item" id="ename" name="ename" placeholder="Example: Sr.">
        </div>
        <div class="form-group">
            <label for="pname">Parent's name:</label>
            <input type="text" class="form-control item" id="pname" name="pname" placeholder="Example: Pname" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control item" id="email" name="email" placeholder="Example: jpg@gmail.com" >
        </div>
        <div class="form-group">
            <label for="lrn">Lrn:</label>
            <input type="text" class="form-control item" id="lrn" name="lrn" placeholder="Example: LRN" required>
        </div>
        <div class="form-group">
            <label for="nickname">Display Name:</label>
            <input type="text" class="form-control item" id="nickname" name="nickname" placeholder="Example: Tutu" required>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control item" id="age" name="age" placeholder="Example: 12" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control item" id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="birthdate">Birthdate:</label>
            <input type="date" class="form-control item" id="birthdate" name="birthdate" placeholder="Example: 01/01/2001" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control item" id="address" name="address" placeholder="Example: Purok. Pinetree, Brgy. Oringao, Kabankalan City, Negros Occidental." required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control item" id="username" name="username" placeholder="Example: @JuanFGSNHS" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control item" id="password" name="password" placeholder="" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <input type="text" class="form-control item" id="role" name="role" value="student" readonly>
        </div>
        <div class="form-group">
            <label for="img">Image:</label>
            <input type="text" class="form-control item" id="img" name="img" placeholder="Example: image.jpg">
        </div>
        <div class="form-group">
            <label for="section">Section:</label>
            <select class="form-control item" id="section" name="section">
                <option value="section1">Section 1</option>
                <option value="section2">Section 2</option>
                <option value="section3">Section 3</option>
                <option value="section4">Section 4</option>
                <option value="section5">Section 5</option>
                <option value="section6">Section 6</option>
                <option value="section7">Section 7</option>
            </select>
        </div>
        <div class="form-group">
            <label for="yearlevel">Year Level:</label>
            <select class="form-control item" id="yearlevel" name="year_level">
                <option value="grade9">Grade 9</option>
                <option value="grade10">Grade 10</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
    </form>
</div>

`;
            // Get the form element
            var form = document.getElementById('studentForm');

            // Attach a submit event handler to the form
            form.addEventListener('submit', function (event) {
                // Prevent the form from being submitted normally
                event.preventDefault();

                // Create a new FormData object from the form
                var formData = new FormData(form);

                // Use AJAX to submit the form data
                var request = new XMLHttpRequest();
                request.open('POST', 'submit.php');
                request.onreadystatechange = function () {
                    if (request.readyState === 4 && request.status === 200) {
                        // The request has completed successfully
                        Swal.fire(
                            'Success!',
                            'New record created successfully',
                            'success'
                        );

                        // Reset the form fields
                        form.reset();
                    }
                };
                request.send(formData);
            });
        }



        function showManageClass() {
            var mainContent = document.getElementById('mainContent');

            // Create the table
            var table = document.createElement('table');
            table.className = 'table table-striped smaller-table';
            table.id = 'studentTable';

            var headers = ['#', 'Full Name', 'Age', 'Gender', 'Birthdate', 'Address', 'Username', 'Password', 'Year Level', 'Section', 'Email', 'LRN'];
            var thead = document.createElement('thead');
            var tr = document.createElement('tr');

            headers.forEach(function (header) {
                var th = document.createElement('th');
                th.scope = 'col';
                th.textContent = header;
                tr.appendChild(th);
            });

            thead.appendChild(tr);
            table.appendChild(thead);

            // Create the table body
            var tbody = document.createElement('tbody');
            table.appendChild(tbody);

            // Add the table to the main content
            mainContent.innerHTML = '<h1 style="text-align: center; margin-top: 20px">List of Students</h1>';
            mainContent.appendChild(table);

            // Load initial data
            showStudents();
        }

        function showStudents() {
            // Fetch the data from the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send();

            xhr.onload = function () {
                if (this.status == 200) {
                    // Parse the response
                    var data = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#studentTable tbody');

                    // Clear the current table data
                    tbody.innerHTML = '';

                    // Add the new data to the table
                    data.forEach(function (row, index) {
                        var tr = document.createElement('tr');

                        // Add each column to the row
                        tr.innerHTML = `
                    <th scope="row">${index + 1}</th>
                    <td>${row.fullname}</td>
                    <td>${row.age}</td>
                    <td>${row.gender}</td>
                    <td>${row.birthdate}</td>
                    <td>${row.address}</td>
                    <td>${row.username}</td>
                    <td>${row.password}</td>
                    <td>${row.year_level}</td>
                    <td>${row.section}</td>
                    <td>${row.email}</td>
                    <td>${row.lrn}</td>
                `;

                        // Add the row to the table body
                        tbody.appendChild(tr);
                    });

                    // If DataTable already exists, destroy it
                    if ($.fn.DataTable.isDataTable('#studentTable')) {
                        $('#studentTable').DataTable().destroy();
                    }

                    // Initialize DataTable with search, entries control, and pagination
                    $('#studentTable').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                }
            };
        }

        // Ensure the function is called to render the manage class table on page load
        document.addEventListener('DOMContentLoaded', function () {
            showManageClass();
        });



        function showFaculty() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `
            <style>
                h1 {
                    margin-top: 20px;
                }
            </style>
        <h1 style="text-align: center;">List of Teachers</h1>
        <table id="adminTable" class="table table-striped smaller-table" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Age</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    `;

            // Fetch the admin data from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_teachers.php', true);
            xhr.onload = function () {
                if (this.status == 200) {
                    // Parse the JSON data
                    var teachers = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#adminTable tbody');

                    // Insert the teacher data into the table
                    for (var i = 0; i < teachers.length; i++) {
                        var tr = document.createElement('tr');
                        var fullname = `${teachers[i].fname} ${teachers[i].mname} ${teachers[i].lname} ${teachers[i].ename}`;
                        tr.innerHTML = `
                    <th scope="row">${i + 1}</th>
                    <td>${fullname}</td>
                    <td>${teachers[i].age}</td>
                    <td>${teachers[i].address}</td>
                    <td>${teachers[i].gender}</td>
                `;
                        tbody.appendChild(tr);
                    }

                    // Initialize DataTable
                    $('#adminTable').DataTable();
                }
            };
            xhr.send();
        }


    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>