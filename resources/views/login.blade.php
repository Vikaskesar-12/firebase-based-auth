<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Firebase Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- ✅ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #fceabb, #f8b500);
      font-family: 'Roboto', sans-serif;
    }
    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .firebase-logo {
      height: 60px;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
      <div class="text-center mb-3">
            <!-- <img src="https://www.gstatic.com/devrel-devsite/prod/v04189a844d33a21dff2ac74f6a134cd51eebafc394b72659d3ed0e8fe0c2b7ff/firebase/images/touchicon-180.png" alt="Firebase Logo" class="firebase-logo"> -->
        <h4 class="mt-2">Firebase Login</h4>
      </div>

      <div class="form-group mb-3">
        <label>Email address</label>
        <input type="email" id="email" class="form-control" placeholder="Enter email">
      </div>

      <div class="form-group mb-4">
        <label>Password</label>
        <input type="password" id="password" class="form-control" placeholder="Enter password">
      </div>

      <button onclick="login()" class="btn btn-warning w-100">Login</button>
      <div id="error-message" class="text-danger mt-3 text-center"></div>
    </div>
  </div>

  <!-- ✅ Firebase JS SDKs -->
  <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-auth-compat.js"></script>

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

    function login() {
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const errorMsg = document.getElementById("error-message");
      errorMsg.innerText = "";

      if (!email || !password) {
        errorMsg.innerText = "Please enter email and password.";
        return;
      }

      firebase.auth().signInWithEmailAndPassword(email, password)
        .then((userCredential) => {
          const user = userCredential.user;
          const uid = user.uid;

          fetch('/verify-user', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ uid: uid, email: user.email })
          })
          .then(response => response.json())
          .then(data => {
            if (data.role === 'admin') {
              window.location.href = '/admin/dashboard';
            } else {
              window.location.href = '/user/dashboard';
            }
          });
        })
        .catch((error) => {
          errorMsg.innerText = error.message;
        });
    }
  </script>

</body>
</html>
