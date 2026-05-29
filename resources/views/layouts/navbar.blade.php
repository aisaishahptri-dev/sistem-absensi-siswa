<nav style="padding: 15px; background: #111; color: white; display: flex; justify-content: space-between; align-items: center;">
    
    <div>
        <strong>My App</strong>
    </div>

    <div style="display: flex; gap: 15px; align-items: center;">
        <span>
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="padding:6px 12px; background:red; color:white; border:none; border-radius:5px; cursor:pointer;">
                Logout
            </button>
        </form>
    </div>

</nav>