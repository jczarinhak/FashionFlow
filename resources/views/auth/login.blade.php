<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    @if ($errors->any())
        <div>
            <strong>{{ $errors->first() }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" required />
        </div>

        <div>
            <label>Senha:</label>
            <input type="password" name="password" required />
        </div>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
