<x-layout>
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Sign Up Form
            </div>
            <div class="card-text">
                <form action="/signup/request" method="POST">
                    @csrf
                    <label for="name">
                    <input type="text" name="name" placeholder="Username"></label>
                    <label for="password">
                    <input type="password" name="password" placeholder="Password">
                    </label>

                    <label for="email">
                        <input type="email" name="email" placeholder="email">
                    </label>
                    <button type="submit">Signup</button>

                </form>
            </div>
        </div>
    </div>

</x-layout>
