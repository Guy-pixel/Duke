<x-layout>
    <?php
    ?>
    <script>
        function signUp(){
            window.location.replace("<?=route('signup');?>");
        }
    </script>
    <div class="inline-view">
        <div class="login-card">
            <div class="login-header">
                Log In
            </div>
            <div class="login-body">
                <form action="/login" method="POST" class="login-form">
                    @csrf
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit">Login</button>
                </form>
                <button class="register-btn" onclick="signUp()">Sign Up</button>
            </div>
            <div class="login-footer">

            </div>
        </div>
    </div>
</x-layout>


