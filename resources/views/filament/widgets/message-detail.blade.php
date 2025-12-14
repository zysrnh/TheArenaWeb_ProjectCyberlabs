<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $message->nama }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
            <p class="text-base text-gray-900 dark:text-white">{{ $message->email }}</p>
        </div>
    </div>

    <div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject</p>
        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $message->subject }}</p>
    </div>

    <div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Message</p>
        <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <p class="text-base text-gray-900 dark:text-white whitespace-pre-wrap">{{ $message->pesan }}</p>
        </div>
    </div>

    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            <span class="font-medium">Received:</span> 
            {{ $message->created_at->format('l, d F Y - H:i:s') }}
            <span class="text-gray-400">({{ $message->created_at->diffForHumans() }})</span>
        </p>
    </div>
</div>