from moviepy.editor import *
import json
import os
import moviepy.editor as mpe
import moviepy.audio.fx.all as afx
from moviepy.editor import vfx
from moviepy.decorators import audio_video_fx
from moviepy.audio.fx.volumex import volumex

from flask import *

app = Flask(__name__)

@app.route("/")
def hello_world():
    return "<p>Hello, World!</p>"

@app.route('/mix-music', methods=['POST'])
def mixAudios():
    output =  request.json["storePath"]
    audios = []
    for layer in request.json["layers"]:
        encodedMP3Path = layer["path"]
        if "webm" in layer["path"]: 
            encodedMP3Path = layer["path"].replace("webm", "mp3")


        stuff_in_string = "ffmpeg -i {} {} -y".format(layer["path"], encodedMP3Path)
        os.system(stuff_in_string)
        substr = ".mp3"
        inserttxt = "volume-changed"
        idx = encodedMP3Path.index(substr)
        volumeEncodedMP3Path = encodedMP3Path[:idx] + inserttxt + encodedMP3Path[idx:]
        os.system("cp {} {}".format(encodedMP3Path, volumeEncodedMP3Path))
        reduceVolume = "ffmpeg -i {} -filter:a \"volume={}\" {} -y".format(encodedMP3Path, layer["volume"], volumeEncodedMP3Path)
        print((reduceVolume))

        os.system(reduceVolume)

        clip = mpe.AudioFileClip(volumeEncodedMP3Path)
        clip = clip.set_duration(layer["duration"])
        trimmedClip = clip.subclip(0, layer["end"] - layer["start"])
        audios.append(trimmedClip.set_start(layer["start"]))

    mixed = CompositeAudioClip(audios)
    mixed.fps = 44100
    mixed.write_audiofile(output)
    return jsonify(request.json["storePath"])