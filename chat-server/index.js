const httpServer = require("http").createServer();
const io = require("socket.io", {
    cors: {
        origin: '*'
    }
})(httpServer);

// TODO: take port - server info from env.
const Redis = require('ioredis');
const redis = new Redis('6379', 'redis');

io.on("connection", function (socket) {
    // TODO: handle no stream id cases etc.
    const {streamId} = socket.handshake.query
    socket.join(`chat:${streamId}`);
});

redis.subscribe('chat-channel');
redis.on('message', function (channel, message) {
    message = JSON.parse(message)
    const streamId = message.data.streamId;
    io.to(`chat:${streamId}`).emit('message',message)
});

httpServer.listen(4000)
