<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students') }}
            </h2>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Add New Student
            </a>
        </div>
    </x-slot>

    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Students Management</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">

    <!-- Filters -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <x-input-label for="search" :value="__('Search')" />
                    <x-text-input id="search" type="text" name="search" :value="request('search')" placeholder="Name, CB number, Email" class="block mt-1 w-full" />
                </div>
                <div>
                    <x-input-label for="programme" :value="__('Programme')" />
                    <select id="programme" name="programme" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">All Programmes</option>
                        <option value="SE" {{ request('programme') === 'SE' ? 'selected' : '' }}>SE</option>
                        <option value="CS" {{ request('programme') === 'CS' ? 'selected' : '' }}>CS</option>
                        <option value="CT" {{ request('programme') === 'CT' ? 'selected' : '' }}>CT</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="batch" :value="__('Batch')" />
                    <x-text-input id="batch" type="text" name="batch" :value="request('batch')" placeholder="e.g., 2024" class="block mt-1 w-full" />
                </div>
                <div>
                    <x-input-label for="semester" :value="__('Semester')" />
                    <x-text-input id="semester" type="number" name="semester" :value="request('semester')" min="1" max="8" placeholder="1-8" class="block mt-1 w-full" />
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CB Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programme</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $student->student_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $student->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $student->programme }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->batch }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->semester }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('students.show', $student) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this, '{{ $student->name }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No students found. <a href="{{ route('students.create') }}" class="text-indigo-600 hover:text-indigo-900">Add your first student</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $students->links() }}
        </div>
    </div>
        </div>
    </div>

    <script>
        function confirmDelete(button, studentName) {
            Swal.fire({
                title: 'Delete Student?',
                text: `Are you sure you want to delete ${studentName}? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-5 py-2.5',
                    cancelButton: 'rounded-lg px-5 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Submit the form
                    button.closest('form').submit();
                }
            });
        }
    </script>
</x-app-layout>
