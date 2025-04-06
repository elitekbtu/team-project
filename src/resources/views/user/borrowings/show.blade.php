<x-borrowing-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-gray-800">Borrowing Details</h3>
            <div class="flex space-x-2">
                <a href="{{ route('user.borrowings.index') }}" class="px-3 py-1 border border-gray-300 text-gray-700 rounded-md text-sm hover:bg-gray-50 transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900">Borrowing №{{ $borrowing->id }}</h4>
                        <div class="mt-2 flex items-center">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($borrowing->status === 'active') bg-green-100 text-green-800
                                @elseif($borrowing->status === 'returned')
                                @elseif($borrowing->status === 'overdue')
                                @else
                                @endif">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h5 class="font-semibold text-gray-500 text-sm uppercase mb-2">Book Information</h5>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h6 class="font-medium text-gray-900">{{ $borrowing->book->title }}</h6>
                            <p class="text-sm text-gray-600">by {{ $borrowing->book->author->getFullNameAttribute()}}</p>
                            <p class="text-xs text-gray-500 mt-1">ISBN: {{ $borrowing->book->isbn }}</p>
                        </div>
                    </div>

                    @if($borrowing->description)
                        <div class="prose max-w-none text-gray-700">
                            <h5 class="font-semibold text-gray-500 text-sm uppercase mb-2">Notes</h5>
                            <p>{{ $borrowing->description }}</p>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-1">
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h5 class="text-sm font-medium text-gray-500 uppercase mb-3 border-b pb-2">Timeline</h5>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Borrowed At</dt>
                                <dd class="text-sm text-gray-900">{{ $borrowing->borrowed_at->format('M j, Y H:i') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Due At</dt>
                                <dd class="text-sm text-gray-900">{{ $borrowing->due_at->format('M j, Y H:i') }}</dd>
                            </div>
                            @if($borrowing->returned_at)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Returned At</dt>
                                    <dd class="text-sm text-gray-900">{{ $borrowing->returned_at->format('M j, Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>

                        @if($borrowing->status !== 'returned')
                            <div class="pt-4 border-t mt-4">
                                <form action="{{ route('user.borrowings.return', $borrowing) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mt-4 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                        Mark as Returned
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-borrowing-layout>
