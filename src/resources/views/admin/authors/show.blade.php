<x-author-layout>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-gray-800">Author Details</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.authors.edit', $author) }}" class="px-3 py-1 border border-indigo-500 text-indigo-600 rounded-md text-sm hover:bg-indigo-50 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.books.index') }}" class="px-3 py-1 border border-gray-300 text-gray-700 rounded-md text-sm hover:bg-gray-50 transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="px-6 py-8">
            <div class="space-y-4">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">{{ $author->full_name }}</h4>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        Created {{ $author->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="text-sm font-medium text-gray-500 mb-2">Author Information</h5>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Bio</dt>
                            <dd class="text-sm text-gray-900">{{ $author->bio ?? 'No bio provided' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Last Updated</dt>
                            <dd class="text-sm text-gray-900">{{ $author->updated_at->format('M j, Y \a\t g:i a') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="text-md font-medium text-gray-900 mb-4">Books by this author</h4>

                @if($author->books->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($author->books as $book)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $book->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No books found by this author.</p>
                @endif
            </div>
        </div>
    </div>
</x-author-layout>
