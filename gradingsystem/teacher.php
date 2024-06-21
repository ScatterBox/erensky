<?php
session_start();
if ($_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}
?>

<body>
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
        <h3>Teacher Dashboard</h3>
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
                <li><a class="dropdown-item" href="#" onclick="showNewClass()">Create Class</a></li>
                <li><a class="dropdown-item" href="#" onclick="showNewTeacher()">View Classes</a></li>
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



        //Add Class//
        function showNewClass() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = ` <?php include 'conn.php'; ?> 
            <style>
                h3 {
                    margin-top: 20px;
                }
            </style>
         <h3>Subject Form</h3>
        <div class="registration-form">
        <form id="classForm" action="subjectform.php" method="post">    
        <div class="form-group">
            <label for="subject_name">Subject Name:</label>
            <input type="text" class="form-control item" id="subject_name" name="subject_name" placeholder="Example: English" required>
        </div>
        <div class="form-group">
            <label for="year_level">Year Level:</label>
            <select class="form-control item" id="year_level">
                <option value="grade9">Grade 9</option>
                <option value="grade10">Grade 10</option>
            </select>
        </div>
        <div class="form-group">
            <label for="section">Section:</label>
            <select class="form-control item" id="section">
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
            <button type="submit" class="btn btn-primary">Create Subject</button>
        </div>
    </form>
    `;
            document.getElementById('classForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                var subject_name = document.getElementById('subject_name').value;
                var year_level = document.getElementById('year_level').value;
                var section = document.getElementById('section').value;

                // Send the form data to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'subjectform.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('subject_name=' + subject_name + '&year_level=' + year_level + '&section=' + section);

                xhr.onload = function () {
                    if (this.status == 200) {
                        // Handle the response from the server
                        var response = JSON.parse(this.responseText);
                        console.log(response);
                        if (response.message === 'New record created successfully') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Class was successfully created!'
                            });
                            // Clear the form
                            document.getElementById('classForm').reset();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error creating the class: ' + response.message
                            });
                        }
                    }
                };
            });
        }



        function showManageClass() {
    var mainContent = document.getElementById('mainContent');

    // Create and configure the grade level selector
    var gradeLevelSelect = document.createElement('select');
    gradeLevelSelect.id = 'gradeLevel';
    gradeLevelSelect.className = 'form-select';
    gradeLevelSelect.style = 'width: auto; display: inline-block; margin-left: 10px;';
    gradeLevelSelect.onchange = function () {
        showStudents(this.value);
    };

    var gradeLevels = ['grade9', 'grade10'];
    gradeLevels.forEach(function (level) {
        var option = document.createElement('option');
        option.value = level;
        option.text = 'Grade ' + level.replace('grade', '');
        gradeLevelSelect.add(option);
    });

    // Add the selectors to the main content
    mainContent.innerHTML = '<h1 style="text-align: center; margin-top: 20px;">List of Students</h1>';
    mainContent.appendChild(gradeLevelSelect);

    // Create the table container
    var tableContainer = document.createElement('div');
    tableContainer.id = 'tableContainer';
    mainContent.appendChild(tableContainer);

    // Load initial data for grade 9 (Modify this if default grade level is different)
    showStudents(gradeLevelSelect.value);
}

function showStudents(gradeLevel) {
    // Fetch the data from the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_data_teacher.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('grade=' + gradeLevel);

    xhr.onload = function () {
        if (this.status == 200) {
            // Parse the response
            var data = JSON.parse(this.responseText);

            // Get the table container
            var tableContainer = document.getElementById('tableContainer');

            // Clear the current table content
            tableContainer.innerHTML = '';

            // Create the table
            var table = document.createElement('table');
            table.className = 'table table-striped smaller-table';
            table.id = 'studentTable';

            // Create the table header
            var headers = ['#', 'Full Name', 'Age', 'Gender', 'Birthdate', 'Address', 'Section'];
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
                    <td>${row.section}</td>
                `;

                // Add the row to the table body
                tbody.appendChild(tr);
            });

            table.appendChild(tbody);

            // Add the table to the container
            tableContainer.appendChild(table);

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