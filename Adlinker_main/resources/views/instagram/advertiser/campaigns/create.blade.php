@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-sm sm:text-lg font-bold text-gray-800 whitespace-nowrap">Create Campaign</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-4 py-4">
            <div class="max-w-4xl mx-auto">
                <!-- Profile Summary Card -->
                <div class="bg-white border border-gray-300 rounded-xl p-4 sm:p-6 mb-6 shadow-lg">
                    <div class="flex items-center">
                        @if($profile->profile_photo)
                            <img src="{{ asset('storage/' . $profile->profile_photo) }}" class="w-16 h-16 rounded-full border-4 border-gray-200 object-cover mr-4">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mr-4 border-4 border-gray-200">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-base sm:text-xl font-bold text-gray-900">Advertising on {{ '@' . $profile->instagram_id }}</h2>
                            <p class="text-gray-600 text-sm">
                                {{ number_format($profile->followers) }} followers • ₹{{ number_format($profile->price_per_story, 2) }} per story
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg border border-[#4895EF]/30">
                    <form action="{{ route('instagram.advertiser.campaigns.store', ['user' => auth()->id()]) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="instagram_profile_id" value="{{ $profile->id }}">

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="ml-3">
                                        <ul class="text-sm text-red-700 list-disc list-inside">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Media Type Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-3">Media Type *</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input class="peer hidden" type="radio" name="media_type" id="typeImage" value="image" checked>
                                    <label for="typeImage" class="flex flex-col items-center justify-center p-3 sm:p-6 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-500">
                                        <svg class="w-12 h-12 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-semibold">Image Story</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="peer hidden" type="radio" name="media_type" id="typeVideo" value="video">
                                    <label for="typeVideo" class="flex flex-col items-center justify-center p-3 sm:p-6 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:ring-2 peer-checked:ring-red-500">
                                        <svg class="w-12 h-12 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-semibold">Video Story</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Media Upload -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Upload Media *</label>
                            <input type="file" name="media_file" id="mediaFile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200" accept="image/*,video/*" required onchange="previewMedia(this)">
                            <p class="text-xs text-gray-500 mt-1">Supported: JPG, PNG, MP4. Max: 10MB. Recommended: 1080x1920 (9:16)</p>
                            
                            <div id="mediaPreview" class="mt-4 hidden">
                                <div class="bg-gray-100 rounded-lg p-4 text-center">
                                    <img id="imagePreview" class="max-h-80 mx-auto rounded hidden">
                                    <video id="videoPreview" class="max-h-80 mx-auto rounded hidden" controls></video>
                                </div>
                            </div>
                        </div>

                        <!-- Advertisement Link Text -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Advertisement Link Text *</label>
                            <input type="text" name="link_text" class="block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-200" placeholder="e.g., Shop Now, Learn More, Visit Website..." value="{{ old('link_text') }}" required>
                            <p class="text-xs text-gray-500 mt-1">Text to display on the story link sticker</p>
                        </div>

                        <!-- Advertisement Link -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Advertisement Link *</label>
                            <input type="url" name="link_url" class="block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-200" placeholder="https://example.com" value="{{ old('link_url') }}" required>
                            <p class="text-xs text-gray-500 mt-1">URL where users will be directed when they swipe up</p>
                        </div>


                        <!-- Price Info -->
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Campaign Price: ₹{{ number_format($profile->price_per_story, 2) }}</p>
                                    <p class="text-sm text-gray-600">Your story will be posted for 24 hours on {{ '@' . $profile->instagram_id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center items-center px-8 py-4 border border-transparent rounded-lg text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Campaign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewMedia(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        const mediaType = document.querySelector('input[name="media_type"]:checked').value;
        
        reader.onload = function(e) {
            document.getElementById('mediaPreview').classList.remove('hidden');
            
            if (mediaType === 'image' || file.type.startsWith('image/')) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('videoPreview').classList.add('hidden');
            } else {
                document.getElementById('videoPreview').src = e.target.result;
                document.getElementById('videoPreview').classList.remove('hidden');
                document.getElementById('imagePreview').classList.add('hidden');
            }
        }
        
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
