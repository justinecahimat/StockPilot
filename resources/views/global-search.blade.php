<form action="{{ route('global.search') }}" method="GET" class="position-relative" style="width: 260px;">
    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
    <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        class="form-control form-control-sm ps-5 bg-white border-0 shadow-sm"
        placeholder="Search anything..."
        autocomplete="off">
</form>