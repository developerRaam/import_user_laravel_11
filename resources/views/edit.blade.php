@extends('base')

@section('content')



<div class="container mt-5">
    <h1 class="text-center mb-4">User Details Form</h1>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-end mb-4">
                <!-- back button -->
                <a href="{{ route('show') }}" class="btn btn-outline-dark btn-lg rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <
                </a>
                <a href="{{ route('show') }}" class="btn btn-primary">Show Users</a>
            </div>
            <!-- User Details Form -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h2 class="h5 mb-0">Update User Details</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image:</label>
                            <input type="file" class="form-control" name="profile_image" accept=".jpg">
                            <img src="{{ ($user->profile_image) ? asset('storage/' . $user->profile_image) : asset('not-image-available.png') }}" width="100" class="img-thumbnail mt-2">
                            <div>
                                <span class="text-danger">
                                    @error('profile_image')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="name" maxlength="25" value="{{ ($user->name) ? $user->name : old('name') }}">
                            <div>
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" name="phone" placeholder="+1-(XXX) XXX-XXXX" value="{{ ($user->phone) ? $user->phone : old('phone') }}">
                            <div>
                                <span class="text-danger">
                                    @error('phone')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" readonly class="form-control" name="email" value="{{ ($user->email) ? $user->email : old('email') }}">
                            <div>
                                <span class="text-danger">
                                    @error('email')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="street_address" class="form-label">Street Address:</label>
                            <input type="text" class="form-control" name="street_address" value="{{ ($user->street_address) ? $user->street_address : old('street_address') }}">
                            <div>
                                <span class="text-danger">
                                    @error('street_address')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="city" class="form-label">City:</label>
                            <input type="text" class="form-control" name="city" value="{{ ($user->city) ? $user->city : old('city') }}">
                            <div>
                                <span class="text-danger">
                                    @error('city')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="state" class="form-label">State:</label>
                            <select class="form-select" name="state">
                                <option value="CA" {{ $user->state === 'CA' ? 'selected' : '' }}>CA</option>
                                <option value="NY" {{ $user->state === 'NY' ? 'selected' : '' }}>NY</option>
                                <option value="AT" {{ $user->state === 'AT' ? 'selected' : '' }}>AT</option>
                            </select>
                            <div>
                                <span class="text-danger">
                                    @error('state')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="country" class="form-label">Country:</label>
                            <select class="form-select" name="country">
                                <option value="IN" {{ $user->country === 'IN' ? 'selected' : '' }}>IN</option>
                                <option value="US" {{ $user->country === 'US' ? 'selected' : '' }}>US</option>
                                <option value="EU" {{ $user->country === 'EU' ? 'selected' : '' }}>EU</option>
                            </select>
                            <div>
                                <span class="text-danger">
                                    @error('country')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection