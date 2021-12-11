<div>
    <textarea wire:model="message" placeholder="Write your message here." class="w-full px-2 py-2 text-gray-700 border-gray-300 rounded-md shadow-sm"></textarea>
    @auth
        <x-jet-button wire:click="sendMessage">Send message</x-jet-button>
    @else    
        <x-jet-button disabled>Log in to send message</x-jet-button>
    @endauth
</div>
