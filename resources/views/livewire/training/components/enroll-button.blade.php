<div>
    <button wire:click="enroll" class="btn btn-primary bg-white text-black rounded-lg p-3" {{ $isEnrolled ? 'bg-gray-800 text-white disabled' : '' }}>
        {{ $isEnrolled ? 'Enrolled' : 'Enroll' }}
    </button>
</div>
