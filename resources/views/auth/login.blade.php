<x-layout-guest page-title="Login">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-4">

                <!-- logo -->
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="200px">
                </div>

                <!-- login form -->
                <div class="card p-5">

                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#">Forgot your password?</a>
                            <input type="submit" class="btn btn-primary px-4" value="LOGIN">
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</x-layout-guest>
