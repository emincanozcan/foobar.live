<p align="center"><img src="/art/banner.png" alt="Banner of FooBar.Live"></p>

# FooBar.Live: Livestreaming platform for developers

[![Actions Status](https://github.com/emincanozcan/foobar.live/workflows/Tests/badge.svg)](https://github.com/emincanozcan/foobar.live/actions)
[![Actions Status](https://github.com/emincanozcan/foobar.live/workflows/Code%20Styling/badge.svg)](https://github.com/emincanozcan/foobar.live/actions)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

[Click here](https://www.youtube.com/watch?v=k9W2BWIGitM) to watch the installation & usage video in Turkish.

# Table of contents

- [Purpose](#purpose)
- [Key Features](#key-features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
  - [Install With Docker - Automatic](#install-with-docker---automatic)
  - [Install With Docker - Manual](#install-with-docker---manual)
- [How To Start A Livestream?](#how-to-start-a-livestream)
  - [Livestreaming With OBS](#livestreaming-with-obs)
  - [Streaming With FFmpeg](#streaming-with-ffmpeg)
- [Security](#security)
- [License](#license)

## Purpose

Developing things and solving problems during a live-stream is fun, educational and also a good opportunity to meet new people.

Unfortunately; popular livestreaming platforms do not focus on developers. It's hard for the developer and the audience to find each other and come together on these platforms.

There are helpful platforms that inform you about live-streams on Youtube, Twitch etc., for example [LaraStreamers](https://larastreamers.com/). I got to know many Laravel streamers from there. 

But these platforms are sharing with you what you are already interested in. They're not good at creating new interests.

This is how the idea of FooBar.Live was born. It emerged as an attempt to solve the mentioned problems.

Also, it started to be created in a Hackathon, [ÜçBüyücü Turnuvası](https://ucbuyucuturnuvasi.com/), this means a lot for this kind of project :).

## Key Features

* Live-streaming without any remote dependencies like YouTube or Twitch. FooBar.Live includes an Nginx RTMP server for video streaming.
* Provides live updates by using a socket connection. When new messages are sent to chat or viewer count is changed, viewers will know that instantly. Not depend on third-party services like Pusher, FooBar.Live contains a socket server and uses Redis pub/sub to communicate.  
* Supports tools that streamers already use. Thanks to RTMP support, OBS and a lot of streaming tools are supported. It is enough to just change the URL and the streaming key.

## Tech Stack

* Nginx RTMP to receive video streaming
* Node.Js / Socket.io for socket server needs
* Redis for pub/sub
* PostgreSQL as database
* PHP Laravel Framework / Jetstream with Livewire Stack for application
* Docker - Docker-Compose to run and orchestrate services. 

## Installation

FooBar.Live is completely dockerized. It is possible to run the project without Docker, but it is not recommended because of the effort that it will take.

Note: FooBar.Live uses these ports: `80, 5342, 6379, 1935, 1936, 4000`. Before installation, it is recommended to ensure that these ports are not used by other processes.

### Install With Docker - Automatic

There is a file in the project called [`setup.sh`](setup.sh), which is a shell script that runs the necessary commands for installation.

If you don't want to run a shell script directly, you can follow the steps at [Install With Docker - Manual](#install-with-docker---manual).

```bash
# Clone this repository
$ git clone https://github.com/emincanozcan/foobar.live.git

# Go into the repository
$ cd foobar.live

# Run the script
$ chmod +x ./setup.sh && ./setup.sh
```


### Install With Docker - Manual

```bash
# Clone this repository
$ git clone https://github.com/emincanozcan/foobar.live

# Go into the repository
$ cd foobar.live

# Create the environment variables file. You can change the configuration in it, but it is recommended to keep it as it is, for the first installation
$ cp .env.example .env

# Install PHP dependencies using a docker container
$ docker run --rm --interactive --tty --volume $PWD:/app --user $(id -u):$(id -g) composer install

# Run the containers
$ ./vendor/bin/sail up -d

# Prepare the application
$ ./vendor/bin/sail artisan key:generate && ./vendor/bin/sail artisan storage:link && ./vendor/bin/sail artisan migrate --seed

# You are ready to go, go to http://localhost and enjoy it ^^
```

## How To Start A Livestream?

### Livestreaming With OBS

[OBS (Open Broadcaster Software)](https://obsproject.com/) is free and open source software for video recording and live-streaming.

* Copy FooBar.Live streaming key from the profile page.
* Open OBS
	* Click on Settings
	* Click on Stream
	* Change Service to "Custom..."
	* Write `rtmp://localhost:1935/stream_receiver` to server field.
	* Paste the stream key that you have copied to the Stream Key field.
	* Click on Apply and Okay
	* The last step; click on the `Start Streaming` button and your first live-stream vie FooBar.Live will be started.
* To watch, go to the `http://localhost/u/{username}` URL or click on My Live Stream button which is located on the header at the Dashboard.

### Streaming With FFmpeg

Especially for development purposes, opening OBS and starting a new live-stream might be a little bit boring after a while. Using FFmpeg is a good alternative for this kind of situation, it allows you to stream a video file to an RTMP server. Because of FFmpeg is a feature-rich program, there are a lot of available configurations. 

If you have interest, you can take a look [FFmpeg Streaming Guide](https://trac.ffmpeg.org/wiki/StreamingGuide) for detailed configurations, working with different data sources etc. Or, If you want to just test it, you can use the command below.

```bash
# Change videofilepath.mkv with your video file, $STREAM_KEY with your stream key.

$ ffmpeg -re -i videofilepath.mp4 -vcodec libx264 -vprofile baseline -g 30 -acodec aac -strict -2 -f flv rtmp://localhost:1935/stream_receiver/$STREAM_KEY
```

## Security

If you discover security-related issues, please email emincanozcann@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
