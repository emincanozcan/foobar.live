<div>
    <textarea wire:model="message" placeholder="Write your message here." class="w-full px-2 py-2 text-gray-700 border-gray-300 rounded-md shadow-sm"></textarea>
    <x-jet-input-error for="message"/>
    @auth
        <x-jet-button class="mt-4" wire:click="sendMessage">Send message</x-jet-button>
    @else    
        <x-jet-button class="mt-4" disabled>Log in to send message</x-jet-button>
    @endauth
</div>
