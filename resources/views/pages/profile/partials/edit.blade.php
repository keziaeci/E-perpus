<div class="rounded-lg bg-white p-8 shadow-lg lg:col-span-3 lg:p-12">

    <form action="{{ route('simpan-profil', Auth::user()->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')
        <div>
            <label class="sr-only" for="name">Name</label>
            <input
            class="w-full rounded-lg border-gray-200 p-3 text-sm"
            placeholder="Name"
            type="text"
            id="name"
            name="name"
            />
        </div>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label class="sr-only" for="username">Username</label>
                <input
                class="w-full rounded-lg border-gray-200 p-3 text-sm"
                placeholder="Username"
                type="text"
                id="username"
                name="username"
                />
            </div>

            <div>
                <label class="sr-only" for="email">Email</label>
                <input
                    class="w-full rounded-lg border-gray-200 p-3 text-sm"
                    placeholder="Email"
                    type="email"
                    id="email"
                    name="email"
                />
            </div>
        </div>

        <div class="mt-4">
            <button
            type="submit"
            class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto"
            >
            Simpan Perubahan
            </button>
        </div>
    </form>

</div>