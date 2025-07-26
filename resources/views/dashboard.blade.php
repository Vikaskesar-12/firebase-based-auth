<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Firebase SDKs -->
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-auth-compat.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            border-radius: 12px;
            padding: 20px;
            background: white;
            margin-bottom: 20px;
        }
        #logout {
            float: right;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🗂️ Task Dashboard</h2>
            <a href="{{ route('add.task.page') }}" class="btn btn-primary mb-3">+ Add New Task</a>
            <button id="logout" class="btn btn-danger">Logout</button>
        </div>

        <div id="taskList" class="row"></div>
    </div>

    <script>
        // ✅ Initialize Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyDu0nuA5HgsF-I-jt7yQX7T35WIWdt96B8",
            authDomain: "laravel-firebase-taskapp.firebaseapp.com",
            projectId: "laravel-firebase-taskapp",
            storageBucket: "laravel-firebase-taskapp.appspot.com",
            messagingSenderId: "177687594502",
            appId: "1:177687594502:web:e0b006b6353e255f626587",
            measurementId: "G-S5P81D48KZ"
        };
        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();

        // ✅ Get Email
        const email = localStorage.getItem("email");

        $(document).ready(function(){
            // ✅ Fetch Tasks
            $.ajax({
                url: "/api/get-tasks",
                method: "POST",
                data: { email: email },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    let html = "";
                    data.forEach(task => {
                        const fields = task.fields;
                        html += `
                            <div class="col-md-6">
                                <div class="task-card">
                                    <h4>${fields.title.stringValue}</h4>
                                    <p>${fields.description.stringValue}</p>
                                    <span class="badge bg-${fields.status.stringValue === 'completed' ? 'success' : 'warning'}">
                                        ${fields.status.stringValue}
                                    </span>
                                </div>
                            </div>
                        `;
                    });
                    $("#taskList").html(html);
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    $("#taskList").html(`<div class="alert alert-danger">Failed to load tasks. Please try again.</div>`);
                }
            });

            // ✅ Logout Button Click
            $("#logout").click(function() {
                auth.signOut().then(() => {
                    localStorage.clear();
                    window.location.href = "/";
                }).catch((error) => {
                    alert("Logout Failed: " + error.message);
                });
            });
        });
    </script>
</body>
</html>
