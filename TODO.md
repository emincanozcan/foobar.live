This is the basic road-map. (Not strict, some topics might be added, removed or reordered.

## Base Features

The base features that project have to have.

[x] Create an RTMP Server by using Nginx. Configure it to receive the live stream, to convert the live stream to HLS, and to serve live stream through an endpoint.
[x] Install Laravel Jetstream with Livewire.
[x] An username and a stream key must be created at user creation.
[x] Configure Nginx and Laravel App to validate this stream key. (If key is wrong, do not allow user to start streaming).
[] Create an endpoint like `service/watch/{username}` to everybody watch streaming of user.
[] For chatting during the live stream, create a chat service with nodejs - socket.io. (Flow: Message -> Laravel App -> Redis -> Socket Server -> Emit To Users)
[] Design the UI, make it a little bit fancy

## Additional Features

The additional features that project good to have.

[] Design the UI, make it more fancy
[] Follower system
[] Subscription system
[] Video quality support
[] Chat moderation things
