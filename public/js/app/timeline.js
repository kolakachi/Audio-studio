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
var signals = {

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
var player = new Player();


// TIME LINE CODE
var keysDown = {};
document.addEventListener( 'keydown', function ( event ) { keysDown[ event.keyCode ] = true; } );
document.addEventListener( 'keyup',   function ( event ) { keysDown[ event.keyCode ] = false; } );
var scale = 32;
var prevScale = scale;
var timeline = document.getElementById("timeline-wrapper");
timeline.addEventListener( 'wheel', function ( event ) {

    if ( event.altKey === true ) {

        event.preventDefault();

        scale = Math.max( 2, scale + ( event.deltaY / 10 ) );

        signals.timelineScaled.dispatch( scale );

    }

});
var canvas = document.getElementById("timeline-canvas");
canvas.addEventListener( 'mousedown', function ( event ) {

    event.preventDefault();

    function onMouseMove( event ) {
        // var currentTime = ( event.offsetX + scroller.scrollLeft ) / scale ;
        // player.currentTime = Math.max( 0, currentTime );
        // signals.timeChanged.dispatch( player.currentTime );
        setTime( ( event.offsetX + scroller.scrollLeft ) / scale );

    }

    function onMouseUp( event ) {

        onMouseMove( event );

        document.removeEventListener( 'mousemove', onMouseMove );
        document.removeEventListener( 'mouseup', onMouseUp );

    }

    document.addEventListener( 'mousemove', onMouseMove, false );
    document.addEventListener( 'mouseup', onMouseUp, false );

}, false );

function updateMarks() {

    canvas.width = scroller.clientWidth;

    var context = canvas.getContext( '2d', { alpha: false } );

    context.fillStyle = '#555';
    context.fillRect( 0, 0, canvas.width, canvas.height );

    context.strokeStyle = '#888';
    context.beginPath();

    context.translate( - scroller.scrollLeft, 0 );

    var duration = 100;//editor.duration;
    var width = duration * scale;
    var scale4 = scale / 4;

    for ( var i = 0.5; i <= width; i += scale ) {
        context.moveTo( i + ( scale4 * 0 ), 18 ); context.lineTo( i + ( scale4 * 0 ), 26 );

        if ( scale > 16 ) context.moveTo( i + ( scale4 * 1 ), 22 ), context.lineTo( i + ( scale4 * 1 ), 26 );
        if ( scale >  8 ) context.moveTo( i + ( scale4 * 2 ), 22 ), context.lineTo( i + ( scale4 * 2 ), 26 );
        if ( scale > 16 ) context.moveTo( i + ( scale4 * 3 ), 22 ), context.lineTo( i + ( scale4 * 3 ), 26 );

    }

    context.stroke();

    context.font = '10px Arial';
    context.fillStyle = '#888'
    context.textAlign = 'center';

    var step = Math.max( 1, Math.floor( 64 / scale ) );

    for ( var i = 0; i < duration; i += step ) {

        var minute = Math.floor( i / 60 );
        var second = Math.floor( i % 60 );

        var text = ( minute > 0 ? minute + ':' : '' ) + ( '0' + second ).slice( - 2 );

        context.fillText( text, i * scale, 13 );

    }

}

var scroller = document.getElementById("scroller");
scroller.addEventListener( 'scroll', function ( event ) {
    updateMarks();
    updateTimeMark();

}, false );

var loopMark = document.getElementById("loop-mark");
var timeMark = document.getElementById("time-mark");
createTimeMarkImage();

// var elements = new TimelineAnimations( editor );
// 	scroller.appendChild( elements.dom );
function updateContainers() {

    // var width = editor.duration * scale;

    // elements.setWidth( width + 'px' );
    // curves.setWidth( width + 'px' );

}

function createTimeMarkImage() {

    var markCanvas = document.getElementById("timeline-mark-canvas");

    var context = markCanvas.getContext( '2d' );
    context.fillStyle = '#f00';
    context.beginPath();
    context.moveTo( 2, 0 );
    context.lineTo( 14, 0 );
    context.lineTo( 14, 10 );
    context.lineTo( 8, 16 );
    context.lineTo( 2, 10 );
    context.lineTo( 2, 0 );
    context.fill();

    // return canvas;

}

signals.timeChanged.add( function () {

    updateTimeMark();

} );

signals.timelineScaled.add( function ( value ) {

    scale = value;

    scroller.scrollLeft = ( scroller.scrollLeft * value ) / prevScale;

    updateMarks();
    updateTimeMark();
    updateContainers();

    prevScale = value;

} );

signals.windowResized.add( function () {

    updateMarks();
    updateContainers();

} );

updateMarks();

function updateTimeMark() {

    var offsetLeft = ( player.currentTime * scale ) - scroller.scrollLeft - 8;

    timeMark.style.left = offsetLeft + 'px';
    // console.log(player.currentTime);

    /*
    if ( editor.player.isPlaying ) {

        var timelineWidth = timeline.dom.offsetWidth - 8;

        // Auto-scroll if end is reached

        if ( offsetLeft > timelineWidth ) {

            scroller.scrollLeft += timelineWidth;

        }

    }
    */

    // TODO Optimise this

    var loop = player.getLoop();

    if ( Array.isArray( loop ) ) {

        var loopStart = loop[ 0 ] * scale;
        var loopEnd = loop[ 1 ] * scale;

        loopMark.style.display = '';
        loopMark.style.left = ( loopStart - scroller.scrollLeft ) + 'px';
        loopMark.style.width = ( loopEnd - loopStart ) + 'px';

    } else {

        loopMark.style.display = 'none';

    }

}

//CONTROLS
var prevBtn = document.getElementById("prev-btn");
var playBtn = document.getElementById("play-btn");
var nextBtn = document.getElementById("next-btn");
prevBtn.addEventListener("click", function () {

    setTime( player.currentTime - 1 );

} );

playBtn.addEventListener("click", function () {

    player.isPlaying ? stop() : play();

} );

signals.playingChanged.add( function ( isPlaying ) {

    playBtn.style.background = isPlaying ? 'url(files/pause.svg)' : 'url(files/play.svg)';

} );


nextBtn.addEventListener("click", function () {

    setTime( player.currentTime + 1 );

} );

var timeText = document.getElementById("time-text");
function updateTimeText( value ) {

    var minutes = Math.floor( value / 60 );
    var seconds = value % 60;
    var padding = seconds < 10 ? '0' : '';

    timeText.innerHTML =  minutes + ':' + padding + seconds.toFixed( 2 ) ;

}
signals.timeChanged.add( function ( value ) {

    updateTimeText( value );

} );

var playbackRateText = document.getElementById("rate-text");
function updatePlaybackRateText( value ) {

    playbackRateText.innerHTML = value.toFixed( 1 ) + 'x' ;

}
signals.playbackRateChanged.add( function ( value ) {

    updatePlaybackRateText( value );

} );

//EDITOR CODE

function setTime ( time ) {

    // location.hash = time;

    player.currentTime = Math.max( 0, time );
    signals.timeChanged.dispatch( player.currentTime );

}

function play () {

    player.play();
    signals.playingChanged.dispatch( true );

}

function stop () {

    player.pause();
    signals.playingChanged.dispatch( false );

}

var prevTime = 0;

	function animate( time ) {

		player.tick( time - prevTime );

		if ( player.isPlaying ) {

			signals.timeChanged.dispatch( player.currentTime );

		}

		prevTime = time;

		requestAnimationFrame( animate );

	}

	requestAnimationFrame( animate );
