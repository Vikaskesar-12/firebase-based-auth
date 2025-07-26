<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700">Task Dashboard</h2>
            <button id="logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Logout</button>
        </div>

        <div id="task-counters" class="text-gray-600 font-medium mb-4">
            Loading task summary...
        </div>

        <input type="text" id="search-task" placeholder="Search tasks..." class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

        <div id="task-list" class="space-y-3">
            <!-- Tasks will be rendered here -->
        </div>
    </div>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyDu0nuA5HgsF-I-jt7yQX7T35WIWdt96B8",
            authDomain: "laravel-firebase-taskapp.firebaseapp.com",
            projectId: "laravel-firebase-taskapp",
            storageBucket: "laravel-firebase-taskapp.firebasestorage.app",
            messagingSenderId: "177687594502",
            appId: "1:177687594502:web:e0b006b6353e255f626587",
            measurementId: "G-S5P81D48KZ"
        };

        firebase.initializeApp(firebaseConfig);

        firebase.auth().onAuthStateChanged((user) => {
            if (user) {
                const email = user.email;
                fetchTasks(email);
            } else {
                window.location.href = '/login';
            }
        });

        function fetchTasks(email) {
            $.ajax({
                url: '/api/get-tasks',
                method: 'POST',
                data: { email: email },
                success: function(res) {
                    const tasks = res.tasks || [];
                    renderTasks(tasks);
                    showCounters(tasks);

                    // Enable search
                    $('#search-task').on('input', function () {
                        const keyword = $(this).val().toLowerCase();
                        const filtered = tasks.filter(task => task.title.toLowerCase().includes(keyword));
                        renderTasks(filtered);
                        showCounters(filtered);
                    });
                }
            });
        }

        function renderTasks(tasks) {
            if (!tasks.length) {
                $('#task-list').html('<p class="text-center text-gray-500">No tasks found.</p>');
                return;
            }

            let html = '';
            tasks.forEach(task => {
                html += `
                    <div class="p-4 bg-white rounded-lg shadow border-l-4 ${task.status === 'completed' ? 'border-green-500' : 'border-yellow-500'}">
                        <h3 class="text-lg font-semibold text-gray-800">${task.title}</h3>
                        <p class="text-sm text-gray-500">Status: <span class="font-medium capitalize">${task.status}</span></p>
                    </div>
                `;
            });
            $('#task-list').html(html);
        }

        function showCounters(tasks) {
            const total = tasks.length;
            const completed = tasks.filter(t => t.status === 'completed').length;
            const pending = tasks.filter(t => t.status === 'pending').length;

            $('#task-counters').html(`
                <div class="flex gap-6 text-gray-700">
                    <span>Total: <strong>${total}</strong></span>
                    <span>Completed: <strong class="text-green-600">${completed}</strong></span>
                    <span>Pending: <strong class="text-yellow-600">${pending}</strong></span>
                </div>
            `);
        }

        $('#logout').on('click', function () {
            firebase.auth().signOut().then(() => {
                localStorage.clear();
                window.location.href = '/login';
            });
        });
    </script>

</body>
</html>
