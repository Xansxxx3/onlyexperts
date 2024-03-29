@include('partials.header')

    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span class="show-hide" onclick="togglePasswordVisibility()">
                    <img src="eye-open.svg" alt="Show/Hide" id="show-hide-icon">
                </span>
            </div>
            <div class="form-group">
                <input type="checkbox" id="remember-me" name="remember-me">
                <label for="remember-me">Remember Me</label>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var icon = document.getElementById("show-hide-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.src = "eye-closed.svg"; // Change image to eye closed
            } else {
                passwordInput.type = "password";
                icon.src = "eye-open.svg"; // Change image to eye open
            }
        }
    </script>
@include('partials.footer')

