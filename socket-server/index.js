const httpServer = require("http").createServer();
const io = require("socket.io", {
    cors: {
        origin: '*'
    }
})(httpServer);

// TODO: take port - server info from env.
const Redis = require('ioredis');
const redis = new Redis('6379', 'redis');
const getRoomName = (streamId) => `stream:${streamId}`;

io.on("connection", function (socket) {
    // TODO: handle no stream id cases etc.
    const {streamId} = socket.handshake.query
    const roomName = getRoomName(streamId)
    socket.join(roomName);
    emitViewersCount(roomName);

    socket.once('disconnect', () => emitViewersCount(roomName));
});

redis.subscribe('socket-channel');
redis.on('message', function (channel, message) {
    message = JSON.parse(message)
    const streamId = message.data.streamId;
    io.to(getRoomName(streamId)).emit('message', message)
});

httpServer.listen(4000)

function emitViewersCount(roomName) {
    const clients = io.sockets.adapter.rooms.get(roomName)
    io.to(roomName).emit('message', {
        'event': 'stream.updateViewersCount',
        'data': {
            'count': clients && clients.size ? clients.size : 0
        }
    })
}
