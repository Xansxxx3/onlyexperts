<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="{{ old('username') }}"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="password_confirmation">Confirm Password:</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation"><br>

        <label for="subscriptionType">Subscription Status:</label><br>
        <input type="text" id="subscriptionType" name="subscriptionType" value="{{ old('subscriptionType') }}"><br>

        <label for="accttype">Account Type:</label><br>
        <input type="text" id="accttype" name="accttype" value="{{ old('accttype') }}"><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>