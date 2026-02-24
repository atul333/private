@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('instagram.publisher.dashboard', ['user' => auth()->id()]) }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-lg font-bold text-gray-800">Add New Instagram Profile</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-4 py-4">
            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-lg border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                <form method="POST" action="{{ route('instagram.publisher.profile.store', ['user' => auth()->id()]) }}" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Profile Photo Upload -->
                        <div class="relative group text-center">
                            <div class="absolute -inset-0.5 bg-gradient-to-r rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Profile Photo</label>
                                <div class="flex justify-center mb-3">
                                    <div class="relative">
                                        <div id="photoPreview" class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center border-4 border-[#4CC9F0]/30 overflow-hidden">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <label for="profile_photo" class="absolute bottom-0 right-0 w-10 h-10 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-full flex items-center justify-center cursor-pointer hover:from-[#B5179E] hover:to-[#560BAD] transition-all duration-200 shadow-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                <input type="file" class="hidden" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(this)">
                                <p class="text-xs text-gray-500">Upload your Instagram profile picture (Optional, Max: 2MB)</p>
                            </div>
                        </div>

                        <!-- Instagram Username -->
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="instagram_id" class="block text-sm font-semibold text-gray-900">Instagram Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">@</span>
                                    </div>
                                    <input type="text" class="pl-7 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('instagram_id') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="instagram_id" name="instagram_id" value="{{ old('instagram_id') }}" placeholder="your_username" required oninput="removeAtSymbol(this)">
                                    <div class="absolute inset-0 rounded-lg pointer-events-none border border-[#4895EF]/30 transition-colors duration-200"></div>
                                </div>
                                <p class="text-xs text-gray-500">Enter your Instagram username without the @ symbol</p>
                                @error('instagram_id')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Price per Story -->
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="price_per_story" class="block text-sm font-semibold text-gray-900">Price per Story (₹)</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('price_per_story') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="price_per_story" name="price_per_story" value="{{ old('price_per_story') }}" placeholder="e.g. 500" required min="0">
                                </div>
                                <p class="text-xs text-gray-500">Set your price for a 24-hour Instagram story</p>
                                @error('price_per_story')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="pt-4">
                            <div class="relative group">
                                <button type="submit" class="w-full flex justify-center items-center px-8 py-4 border border-transparent rounded-lg text-base font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Instagram Profile
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').innerHTML = '<img src="'+e.target.result+'" class="w-full h-full object-cover rounded-full">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAtSymbol(input) {
    // Remove @ symbol if user types it
    input.value = input.value.replace(/@/g, '');
}
</script>
@endsection
