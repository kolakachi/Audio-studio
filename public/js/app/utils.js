function Player() {

	let audio = null;

	let isPlaying = false;

	let currentTime = 0;
	let playbackRate = 1;

	let loop = null;

	return {
		get isPlaying() {
			return isPlaying;
		},
		get currentTime() {
			if ( audio ) return audio.currentTime;
			return currentTime;
		},
		set currentTime( value ) {
			if ( audio ) audio.currentTime = value;
			currentTime = value;
		},
		get playbackRate() {
			if ( audio ) return audio.playbackRate;
			return playbackRate;
		},
		set playbackRate( value ) {
			playbackRate = value;
			if ( audio ) audio.playbackRate = value;
		},
		getAudio: function () {
			return audio;
		},
		setAudio: function ( value ) {
			if ( audio ) audio.pause();
			if ( value ) {
				value.currentTime = currentTime;
				if ( isPlaying ) value.play();
			}
			audio = value;
		},
		getLoop: function () {
			return loop;
		},
		setLoop: function ( value ) {
			loop = value;
		},
		play: function () {
			if ( audio ) audio.play();
			isPlaying = true;
		},
		pause: function () {
			if ( audio ) audio.pause();
			isPlaying = false;
		},
		tick: function ( delta ) {
			if ( audio ) {
				currentTime = audio.currentTime;
			} else if ( isPlaying ) {
				currentTime += ( delta / 1000 ) * playbackRate;
			}
			if ( loop ) {
				if ( currentTime > loop[ 1 ] ) currentTime = loop[ 0 ];
			}
		}

	}

}

var Signal = signals.Signal;
var editorSignals = {

    editorCleared: new Signal(),

    // scripts

    scriptAdded: new Signal(),
    scriptSelected: new Signal(),
    scriptChanged: new Signal(),
    scriptRemoved: new Signal(),
    scriptsCleared: new Signal(),

    // effects

    effectAdded: new Signal(),
    effectRenamed: new Signal(),
    effectRemoved: new Signal(),
    effectSelected: new Signal(),
    effectCompiled: new Signal(),

    // actions

    fullscreen: new Signal(),
    exportState: new Signal(),

    // animations

    animationRenamed: new Signal(),
    animationAdded: new Signal(),
    animationModified: new Signal(),
    animationRemoved: new Signal(),
    animationSelected: new Signal(),

    // curves

    curveAdded: new Signal(),

    // events

    playingChanged: new Signal(),
    playbackRateChanged: new Signal(),
    timeChanged: new Signal(),
    timelineScaled: new Signal(),

    windowResized: new Signal()

};