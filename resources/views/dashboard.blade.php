<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Log Out</button>
</form>
