<x-layout>
    <div class="inline-view">
        <div class="signup-form-card card">
            <div class="card-body">
                <div class="signup-form-title card-title">
                    Sign Up Form
                </div>
                <div class="signup-form-text card-text">
                    <form class="signup-form" action="/signup/request" method="POST">
                        @csrf
                        <label for="name">
                            <input class="signup-form-inputs" type="text" name="username" placeholder="Username"></label>
                        <label for="password">
                            <input class="signup-form-inputs" type="password" name="password" placeholder="Password">
                        </label>

                        <label for="email">
                            <input class="signup-form-inputs" type="email" name="email" placeholder="email">
                        </label>
                        <button type="submit">Signup</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-layout>
