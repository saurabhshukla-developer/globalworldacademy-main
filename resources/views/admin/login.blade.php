<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Login — Global World Academy</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"/>
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="login-logo-mark">GW</div>
      <div class="login-logo-name">Global <span>World</span> Academy</div>
    </div>
    <div class="login-heading">Admin Panel</div>
    <div class="login-sub">Sign in to manage your website content.</div>

    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="form-group">
        <label class="form-label" for="email">Email Address <span class="req">*</span></label>
        <input type="email" id="email" name="email"
               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email') }}" placeholder="admin@globalworldacademy.com" required autofocus/>
        @error('email')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password <span class="req">*</span></label>
        <input type="password" id="password" name="password"
               class="form-control" placeholder="••••••••" required/>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input type="checkbox" id="remember" name="remember"/>
          <label for="remember">Remember me</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Sign In &rarr;</button>
    </form>

    <div class="login-hint">
      <a href="{{ route('home') }}" target="_blank">&larr; Back to Website</a>
    </div>
  </div>
</div>
</body>
</html>
