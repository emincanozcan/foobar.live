<div>
    <input type="text" wire:model="message">
    @auth
        <x-jet-button wire:click="sendMessage">Send message</x-jet-button>
    @else    
        <x-jet-button disabled>Log in to send message</x-jet-button>
    @endauth
</div>
