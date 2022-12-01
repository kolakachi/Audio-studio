from moviepy.editor import *
import json
import os
from random import randint
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
    pathToDeleteList = []
    # encodedMP3Path = ""
    # volumeEncodedMP3Path = ""
    for layer in request.json["layers"]:
        encodedMP3Path = layer["path"]
        value = randint(0, 10)
        if "webm" in layer["path"]: 
           
            encodedMP3Path = layer["path"].replace(".webm",str(value)+ ".mp3")
            stuff_in_string = "ffmpeg -i {} {} -y".format(layer["path"], encodedMP3Path)
            os.system(stuff_in_string)
        else:
            encodedMP3Path = layer["path"]

       
        substr = ".mp3"
        inserttxt = str(value)+ "-volume-changed"
        idx = encodedMP3Path.index(substr)
        volumeEncodedMP3Path = encodedMP3Path[:idx] + inserttxt + encodedMP3Path[idx:]
        os.system("cp {} {}".format(encodedMP3Path, volumeEncodedMP3Path))
        reduceVolume = "ffmpeg -i {} -filter:a \"volume={}\" {} -y".format(encodedMP3Path, layer["volume"], volumeEncodedMP3Path)

        os.system(reduceVolume)

        clip = mpe.AudioFileClip(volumeEncodedMP3Path)
        clip = clip.set_duration(layer["originalDuration"])
        trimmedClip = clip.subclip(layer["playStart"], layer["playEnd"])
        audios.append(trimmedClip.set_start(layer["start"]))
        
        pathToDeleteList.append(volumeEncodedMP3Path)
        if "webm" in layer["path"]:
            pathToDeleteList.append(encodedMP3Path)

    mixed = CompositeAudioClip(audios)
    mixed.fps = 44100
    mixed.write_audiofile(output)
    
    for pathToDelete in pathToDeleteList:
        os.system("rm "+ pathToDelete)

    finalPath = request.json["storePath"]
    if request.json["format"] == "ogg":
        finalPath = request.json["storePath"].replace(".mp3",str(value)+ ".ogg")
        convertAudioFormat ="ffmpeg -i "+ request.json["storePath"] +" -c:a libvorbis -q:a 4 "+ finalPath
        os.system(convertAudioFormat)
        os.system("rm "+ request.json["storePath"])
    if request.json["format"] == "webm": 
        finalPath = request.json["storePath"].replace(".mp3",str(value)+ ".webm")
        convertAudioFormat ="ffmpeg -i "+ request.json["storePath"] +" -c:a libvorbis -q:a 4 "+ finalPath
        os.system(convertAudioFormat)
        os.system("rm "+ request.json["storePath"])
    return jsonify(finalPath)