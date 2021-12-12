# FooBar.Live

A live streaming platform for developers.

## Why?

Developing things and solving problems during a live stream is fun, educational and also a good opportunity to meet new people.

Unfortunately; popular live-streaming platforms does not focus on developers. It's hard for the developer and the audience to find each other and come together on these platforms. (especially If the streamer is not very popular in the community.)

E.g; I like Laravel but YouTube doesn't give me good enough recommendations. Thankfully, I found [LaraStreamers](https://larastreamers.com/), which is a platform that shares Laravel streamers. I got to know many Laravel streamers from there. 

On the other hand; even though Larastreamers and similar projects really help, I don't believe this is the best approach to solving this problem. These platforms are sharing with you what you are already interested in. They're not good at creating new interests.

This is how the idea of FooBar.Live was born. It emerged as an attempt to solve the mentioned problems. Also, it started to be created in a Hackathon, [ÜçBüyücü Turnuvası](https://ucbuyucuturnuvasi.com/), this means a lot for this kind of project :).

## Key Features

* Live-streaming without any remote dependencies like YouTube or Twitch. FooBar.Live includes a Nginx RTMP server for video streaming.
* Provides live update by using socket connection. When new messages are sent to chat or viewer count is changed, viewers will know that instantly. Not depend on a third party service like Pusher, FooBar.Live contains a socket server and uses Redis pub/sub to communicate.  
* Supports tools that live streamers already use. Thanks to RTMP support, OBS and a lot of streaming tools are supported. It is enough to just change URL and streaming key.


## Installation

FooBar.Tv is completely dockerized. It is possible to run the project without Docker, but it is not recommended because of the effort that it will take.

### Install With Docker - Automatic

There is a file in the project called [`setup.sh`](setup.sh), it is basically a shell script that runs the necessary commands for installation.

If you don't want to run a shell script directly, you can follow the steps at (#install-with-docker---manual)[Install With Docker - Manual].

```bash
# Clone this repository
$ git clone https://github.com/emincanozcan/foobar.live

# Go into the repository
$ cd foobar.live

# Run the script
$ chmox +x ./setup.sh && ./setup.sh
```


### Install With Docker - Manual

```bash
# Clone this repository
$ git clone https://github.com/emincanozcan/foobar.live

# Go into the repository
$ cd foobar.live

# Create the environment variables file. You can change the configuration in it, but it is recommended to keep it as it for first installation.
$ cp .env.example .env

# Install PHP dependencies using a docker container
$ docker run --rm --interactive --tty --volume $PWD:/app composer install

# Run the containers
$ ./vendor/bin/sail up -d

# Prepare the application
$ ./vendor/bin/sail artisan key:generate && ./vendor/bin/sail artisan storage:link && ./vendor/bin/sail artisan migrate --seed

# You are ready to go, go to http://localhost and enjoy it ^^
```

## How To Start A Live Stream?

### With OBS

[OBS (Open Broadcaster Software)](https://obsproject.com/) is free and open source software for video recording and live-streaming.

* Copy FooBar.Live streaming key from the profile page.
* Open OBS
	* Click on Settings
	* Click on Stream
	* Change Service to "Custom..."
	* Write `rtmp://localhost:1935/stream_receiver` to server field.
	* Paste your stream key that you have copied to Stream Key field.
	* Click on Apply and Okay
	* Last step; click on `Start Streaming` button and your first live stream vie FooBar.Live will be started.
* Go to the `http://localhost/u/{username}` URL or click on My Live Stream button which located on the header at the Dashboard.

### With FFmeg

Especially for development purposes, opening OBS and starting a new live stream might be a little bit boring after a while. Using FFmpeg is a good alternative for this kind of situations, it allows you to stream a video file to a RTMP server. Because of FFmpeg is a feature-rich program, there a lot of available configurations. 

If you have interest, you can take a look [FFmpeg Streaming Guide](https://trac.ffmpeg.org/wiki/StreamingGuide) for detailed configurations, working with different data sources etc. Or, If you want to just test it, you can use the command below.

```bash
# Change videofilepath.mkv with your video file, $STREAM_KEY with your stream key.

$ ffmpeg -re -i videofilepath.mp4 -vcodec libx264 -vprofile baseline -g 30 -acodec aac -strict -2 -f flv rtmp://localhost:1935/stream_receiver/$STREAM_KEY
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
