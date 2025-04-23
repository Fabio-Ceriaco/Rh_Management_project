<div class="col-6">
    <div class="border p-5 shadow-sm">
        <form action="{{ route('change.useraddress')}}" method="post">
            @csrf
            @method('put')
            <h3>Change user address</h3>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $collaborator->detail->address)}}">
                @error('address')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="d-flex gap-3">
                <div class="mb-3">
                    <label for="zip_code" class="form-label">Zip code</label>
                    <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ old('zip_code', $collaborator->detail->zip_code)}}">
                    @error('zip_code')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $collaborator->detail->city)}}">
                    @error('city')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $collaborator->detail->phone)}}">
                @error('phone')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update user address</button>
            </div>

        </form>


        @if (session('success_change_address'))
            <div class="alert alert-success mt-3">
                {{ session('success_change_address')}}
            </div>
        @endif

    </div>
</div>
