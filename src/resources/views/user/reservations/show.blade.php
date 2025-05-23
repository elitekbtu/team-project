<x-reservation-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-gray-800">Reservation Details</h3>
            <div class="flex space-x-2">
                <a href="{{ route('user.reservations.index') }}" class="px-3 py-1 border border-gray-300 text-gray-700 rounded-md text-sm hover:bg-gray-50 transition">
                    Back to My Reservations
                </a>
            </div>
        </div>

        <div class="px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900">Reservation №{{ $reservation->id }}</h4>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($reservation->status === 'active') bg-blue-100 text-blue-800
                                @elseif($reservation->status === 'completed') bg-green-100 text-green-800
                                @elseif($reservation->status === 'canceled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                            @if($reservation->isExpired && $reservation->status !== 'canceled' && $reservation->status !== 'completed')
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                    Expired
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h5 class="font-semibold text-gray-500 text-sm uppercase mb-2">Book Information</h5>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h6 class="font-medium text-gray-900">{{ $reservation->book->title }}</h6>
                            <p class="text-sm text-gray-600">by {{ $reservation->book->author ? $reservation->book->author->getFullNameAttribute() : 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-1">ISBN: {{ $reservation->book->isbn ?? 'N/A' }}</p>
                            <p class="mt-2">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($reservation->book->status === 'available') bg-green-100 text-green-800
                                    @elseif($reservation->book->status === 'reserved') bg-blue-100 text-blue-800
                                    @elseif($reservation->book->status === 'unavailable') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($reservation->book->status) }}
                                </span>
                                <span class="ml-2 text-gray-600 text-sm">
                                    (Available copies: {{ $reservation->book->available_copies }})
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($reservation->description)
                        <div class="prose max-w-none text-gray-700">
                            <h5 class="font-semibold text-gray-500 text-sm uppercase mb-2">Notes</h5>
                            <p>{{ $reservation->description }}</p>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-1">
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h5 class="text-sm font-medium text-gray-500 uppercase mb-3 border-b pb-2">Timeline</h5>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Reserved At</dt>
                                <dd class="text-sm text-gray-900">{{ $reservation->reserved_at->format('M j, Y H:i') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Expires At</dt>
                                <dd class="text-sm @if($reservation->isExpired) text-red-600 font-medium @endif">
                                    {{ $reservation->expires_at->format('M j, Y H:i') }}
                                </dd>
                            </div>
                            @if($reservation->status === 'canceled' && $reservation->canceled_at)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Canceled At</dt>
                                    <dd class="text-sm text-gray-900">{{ $reservation->canceled_at->format('M j, Y H:i') }}</dd>
                                </div>
                            @endif
                            @if($reservation->status === 'completed' && $reservation->completed_at)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Completed At</dt>
                                    <dd class="text-sm text-gray-900">{{ $reservation->completed_at->format('M j, Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>

                        <div class="pt-4 border-t mt-4 space-y-3">
                            @if($reservation->canBeCanceled())
                                <form action="{{ route('user.reservations.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                    @csrf
                                    <button type="submit" class="w-35 px-4 py-2 border border-red-300 rounded-lg text-red-700 bg-red-100 hover:bg-red-200 transition flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Cancel Reservation
                                    </button>
                                </form>
                            @endif

                            @if($reservation->status === 'active')
                                <form action="{{ route('user.reservations.create-borrowing', $reservation) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-35 px-6 py-2 mt-2 border border-green-300 rounded-lg text-green-700 bg-green-100 hover:bg-green-200 transition flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                                        </svg>
                                        Borrow This Book
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-reservation-layout>
