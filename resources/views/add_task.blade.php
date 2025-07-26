<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .form-container {
            max-width: 600px;
            margin: 60px auto;
        }
    </style>
</head>
<body>

<div class="container form-container">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">📝 Add New Task</h3>
        </div>
       <div class="card-body">
    <form method="POST" action="{{ route('save.task') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter task title" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Task Description</label>
            <textarea name="description" class="form-control form-control-lg" rows="4" placeholder="Enter task description" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

       
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Assigned To (Email)</label>
            <input type="email" name="assigned_to" class="form-control" value="{{ session('email') }}" readonly>
        </div>

        <button type="submit" class="btn btn-success w-100 py-2">
            ➕ Add Task
        </button>
    </form>
</div>

    </div>
</div>

<script>
    document.querySelector('input[name="assigned_to"]').value = localStorage.getItem("email");
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
