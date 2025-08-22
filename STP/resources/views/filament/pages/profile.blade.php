<x-filament::page>
    <h2>Profile</h2>
    <div>
        <img src="{{ Auth::user()->getFilamentAvatarUrl() }}" alt="Profile Photo" style="width:100px;height:100px;border-radius:50%">
        <p>Name: {{ Auth::user()->name }}</p>
        <p>Email: {{ Auth::user()->email }}</p>
    </div>
</x-filament::page>
