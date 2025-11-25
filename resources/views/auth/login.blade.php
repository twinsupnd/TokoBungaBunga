<form class="auth-form" id="signin-form" method="POST" action="{{ route('login') }}" style="width: 100%;">
    @csrf

    <h2 style="font-family: var(--font-display); color: var(--color-accent-strong); margin-bottom: 15px; text-align: center;">Sign In</h2>

    <div class="form-group">
        <label for="signin-email">Email</label>
        <input id="signin-email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input">
        @error('email') <span class="text-danger" style="color: var(--color-accent-strong); font-size: 12px; display: block;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="signin-password">Password</label>
        <input id="signin-password" type="password" name="password" required autocomplete="current-password" class="form-input">
        @error('password') <span class="text-danger" style="color: var(--color-accent-strong); font-size: 12px; display: block;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="signin-role">Role</label>
        <select id="signin-role" name="role" class="form-input">
            <option value="">Select your role</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; margin-bottom: 20px;">
        <label for="remember_me" style="font-size: 13px; display: flex; align-items: center;">
            <input id="remember_me" type="checkbox" name="remember" style="margin-right: 5px;">
            Remember me
        </label>

        @if (Route::has('password.request'))
            <p class="forgot-password" style="margin: 0;"><a href="{{ route('password.request') }}">Forgot Password?</a></p>
        @endif
    </div>

    <button type="submit" class="form-submit-button">
        Sign In
    </button>
</form>