@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4 mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
            <div class="px-4 py-3 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/campaigns/create" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Back</span>
                        </a>
                        <h1 class="ml-4 text-xl font-bold text-white">Channel Details</h1>
                    </div>
                </div>
            </div>

                
               
            </div>

            <div class="relative p-6">
                <div class="flex flex-col md:flex-row md:space-x-6">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                        <div class="relative flex-shrink-0 mb-4 md:mb-0">
                            @if($channel->logo_path)
                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-24 h-24 rounded-full object-cover shadow-lg border-2 border-[#4895EF]/30 transform transition-all duration-300 hover:scale-105">
                            @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-user-circle text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <div class="relative group mb-6">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative bg-white/80 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $channel->name }}</h2>
                                <p class="text-gray-600">{{ $channel->description }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/80 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Channel Link</h3>
                                    <a href="{{ $channel->link }}" target="_blank" class="text-[#4361EE] hover:text-[#3A0CA3] break-all transition-colors duration-200">{{ $channel->link }}</a>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/80 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Subscribers</h3>
                                    <p class="text-gray-800">{{ number_format($channel->subscribers_count) }}</p>
                                </div>
                            </div>
                        </div>

                        @if(request('duration') && request('price'))
                            <div class="relative group mt-6">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/80 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20">
                                    <h4 class="text-xl font-bold text-gray-900 mb-6">Booking Details</h4>
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Duration:</span>
                                            <span class="font-semibold text-[#3A0CA3]">{{ request('duration') }} Days</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-6">
                                            <span class="text-gray-600">Price:</span>
                                            <span class="font-semibold text-[#3A0CA3]">${{ request('price') }}</span>
                                        </div>
                                
                                 <form method="POST" action="{{ route('campaigns.store', ['user' => auth()->id()]) }}" class="space-y-6" enctype="multipart/form-data">
                                     @csrf
                                     <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                                     <input type="hidden" name="duration" value="{{ request('duration') }}">
                                     <input type="hidden" name="price" value="{{ request('price') }}">

                                     <div class="relative group">
                                         <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                         <div class="relative space-y-2">
                                             <label for="title" class="block text-sm font-semibold text-gray-900">Campaign Title</label>
                                             <input type="text" name="title" id="title" class="mt-1 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200" required>
                                         </div>
                                     </div>

                                     <div class="relative group">
                                         <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                         <div class="relative space-y-2">
                                             <label for="description" class="block text-sm font-semibold text-gray-900">Campaign Description</label>
                                             <textarea name="description" id="description" rows="3" class="mt-1 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200" required></textarea>
                                         </div>
                                     </div>

                                     <div class="relative group">
                                         <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                         <div class="relative space-y-2">
                                             <label for="media" class="block text-sm font-semibold text-gray-900">Media File (Optional)</label>
                                             <input type="file" name="media" id="media" class="mt-1 block w-full px-4 py-3 text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#4CC9F0]/10 file:text-[#4361EE] hover:file:bg-[#4CC9F0]/20 transition duration-200">
                                         </div>
                                     </div>

                                     <div class="pt-6">
                                         <div class="relative group">
                                             <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-25"></div>
                                             <button type="submit" class="relative w-full flex justify-center items-center px-8 py-4 border border-transparent rounded-lg text-base font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                                 Create Campaign
                                                 <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                     <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                 </svg>
                                             </button>
                                         </div>
                                     </div>
                                 </form>
                            </div>
                        @else
                            <div class="mt-4 p-4 rounded-md bg-yellow-50 border border-yellow-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">Please select a duration and price on the previous page before proceeding.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($channel->price_1_day)
                <div class="relative group mt-6">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                    <div class="relative bg-white/80 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20">
                        <h4 class="text-xl font-bold text-gray-900 mb-6">Advertising Plans</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @if($channel->price_1_day)
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20 transform transition-all duration-300 hover:scale-[1.02]">
                                    <div class="text-center">
                                        <h5 class="text-lg font-semibold text-gray-900">1 Day</h5>
                                        <p class="mt-4 text-3xl font-bold text-[#4361EE]">${{ $channel->price_1_day }}</p>
                                        <a href="{{ route('campaigns.channel-details', ['user' => auth()->id(), 'channel' => $channel, 'duration' => 1, 'price' => $channel->price_1_day]) }}" 
                                           class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                            Select Plan
                                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($channel->price_2_days)
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20 transform transition-all duration-300 hover:scale-[1.02]">
                                    <div class="text-center">
                                        <h5 class="text-lg font-semibold text-gray-900">2 Days</h5>
                                        <p class="mt-4 text-3xl font-bold text-[#4361EE]">${{ $channel->price_2_days }}</p>
                                        <a href="{{ route('campaigns.channel-details', ['user' => auth()->id(), 'channel' => $channel, 'duration' => 2, 'price' => $channel->price_2_days]) }}" 
                                           class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                            Select Plan
                                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($channel->price_3_days)
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20 transform transition-all duration-300 hover:scale-[1.02]">
                                    <div class="text-center">
                                        <h5 class="text-lg font-semibold text-gray-900">3 Days</h5>
                                        <p class="mt-4 text-3xl font-bold text-[#4361EE]">${{ $channel->price_3_days }}</p>
                                        <a href="{{ route('campaigns.channel-details', ['user' => auth()->id(), 'channel' => $channel, 'duration' => 3, 'price' => $channel->price_3_days]) }}" 
                                           class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                            Select Plan
                                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($channel->price_7_days)
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-lg border border-[#4895EF]/20 transform transition-all duration-300 hover:scale-[1.02]">
                                    <div class="text-center">
                                        <h5 class="text-lg font-semibold text-gray-900">7 Days</h5>
                                        <p class="mt-4 text-3xl font-bold text-[#4361EE]">${{ $channel->price_7_days }}</p>
                                        <a href="{{ route('campaigns.channel-details', ['user' => auth()->id(), 'channel' => $channel, 'duration' => 7, 'price' => $channel->price_7_days]) }}" 
                                           class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                            Select Plan
                                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview functionality
    const imageInput = document.getElementById('advertisement_image');
    const form = document.querySelector('form');

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) { // 2MB limit
                    alert('Image size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    const existingPreview = document.querySelector('.image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Create new preview
                    const preview = document.createElement('div');
                    preview.className = 'image-preview mt-2';
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="max-w-xs rounded-lg shadow-sm">
                        <button type="button" class="mt-2 text-sm text-red-600 hover:text-red-700" onclick="removeImage()">
                            <i class="fas fa-times mr-1"></i>Remove
                        </button>
                    `;
                    imageInput.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Remove image preview
    function removeImage() {
        const preview = document.querySelector('.image-preview');
        if (preview) {
            preview.remove();
        }
        if (imageInput) {
            imageInput.value = '';
        }
    }

    // Form validation
    if (form) {
        form.addEventListener('submit', function(e) {
            const content = document.getElementById('advertisement_content');
            const image = document.getElementById('advertisement_image');

            if (!content.value.trim()) {
                e.preventDefault();
                alert('Please enter advertisement content');
                content.focus();
                return;
            }

            if (!image.files.length) {
                e.preventDefault();
                alert('Please select an image for the advertisement');
                return;
            }
        });
    }
</script>
@endpush




