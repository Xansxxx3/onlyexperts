@include('partials.header')
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
        
        <label for="firstname">First Name:</label><br>
        <input type="firstname" id="firstname" name="firstname" value="{{ old('firstname') }}"><br>

        <label for="lastname">Last Name:</label><br>
        <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"><br>


        <button type="submit">Register</button>
    </form>
@include('partials.footer')