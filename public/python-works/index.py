from moviepy.editor import *
import json
import os

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
            print(encodedMP3Path)

        stuff_in_string = "ffmpeg -i {} {} -y".format(layer["path"], encodedMP3Path)
        print(encodedMP3Path)
        os.system(stuff_in_string)
        clip = AudioFileClip(encodedMP3Path)
        clip = clip.set_duration(10)
        trimmedClip = clip.subclip(0, layer["end"] - layer["start"])
        audios.append(trimmedClip.set_start(layer["start"]))
# #   print(i)
# #     clip1 = AudioFileClip("audio-1.mp3")
# #     clip2 = AudioFileClip("audio-2.mp3")

    mixed = CompositeAudioClip(audios)
    mixed.fps = 44100
    mixed.write_audiofile(output)
    return jsonify(request.json["storePath"])