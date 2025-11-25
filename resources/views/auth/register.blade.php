<form class="auth-form" id="signup-form" method="POST" action="{{ route('register') }}" style="width: 100%;">
    @csrf

    <h2 style="font-family: var(--font-display); color: var(--color-accent-strong); margin-bottom: 15px; text-align: center;">Let's Join Whispering Flora!</h2> 

    <div class="form-group">
        <label for="signup-name">Full Name</label>
        <input id="signup-name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input">
        @error('name') <span class="text-danger" style="color: var(--color-accent-strong); font-size: 12px; display: block;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="signup-email">Email</label>
        <input id="signup-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-input">
        @error('email') <span class="text-danger" style="color: var(--color-accent-strong); font-size: 12px; display: block;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="signup-password">Password</label>
        <input id="signup-password" type="password" name="password" required autocomplete="new-password" class="form-input">
        @error('password') <span class="text-danger" style="color: var(--color-accent-strong); font-size: 12px; display: block;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="signup-confirm-password">Confirm Password</label>
        <input id="signup-confirm-password" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input">
        @error('password_confirmation') <span class="text-danger" style="color: var(--color-accent-strong); font-size: 12px; display: block;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="signup-role">Role</label>
        <select id="signup-role" name="role" class="form-input">
            <option value="">Select your role</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
        </select>
    </div>

    <button type="submit" class="form-submit-button" style="margin-top: 15px;">
        Sign Up
    </button>
</form>