<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style>
        /*! modern-normalize v1.0.0 | MIT License | https://github.com/sindresorhus/modern-normalize */

/*
Document
========
*/

/**
Use a better box model (opinionated).
*/

*,
*::before,
*::after {
  box-sizing: border-box;
}

/**
Use a more readable tab size (opinionated).
*/

:root {
  tab-size: 4;
}

/**
1. Correct the line height in all browsers.
2. Prevent adjustments of font size after orientation changes in iOS.
*/

html {
  line-height: 1.15; /* 1 */
  -webkit-text-size-adjust: 100%; /* 2 */
}

/*
Sections
========
*/

/**
Remove the margin in all browsers.
*/

body {
  margin: 0;
}

/**
Improve consistency of default fonts in all browsers. (https://github.com/sindresorhus/modern-normalize/issues/3)
*/

body {
  font-family:
		system-ui,
		-apple-system, /* Firefox supports this but not yet `system-ui` */
		'Segoe UI',
		Roboto,
		Helvetica,
		Arial,
		sans-serif,
		'Apple Color Emoji',
		'Segoe UI Emoji';
}

/*
Grouping content
================
*/

/**
1. Add the correct height in Firefox.
2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
*/

hr {
  height: 0; /* 1 */
  color: inherit; /* 2 */
}

/*
Text-level semantics
====================
*/

/**
Add the correct text decoration in Chrome, Edge, and Safari.
*/

abbr[title] {
  text-decoration: underline dotted;
}

/**
Add the correct font weight in Edge and Safari.
*/

b,
strong {
  font-weight: bolder;
}

/**
1. Improve consistency of default fonts in all browsers. (https://github.com/sindresorhus/modern-normalize/issues/3)
2. Correct the odd 'em' font sizing in all browsers.
*/

code,
kbd,
samp,
pre {
  font-family:
		ui-monospace,
		SFMono-Regular,
		Consolas,
		'Liberation Mono',
		Menlo,
		monospace; /* 1 */
  font-size: 1em; /* 2 */
}

/**
Add the correct font size in all browsers.
*/

small {
  font-size: 80%;
}

/**
Prevent 'sub' and 'sup' elements from affecting the line height in all browsers.
*/

sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
}

sub {
  bottom: -0.25em;
}

sup {
  top: -0.5em;
}

/*
Tabular data
============
*/

/**
1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
*/

table {
  text-indent: 0; /* 1 */
  border-color: inherit; /* 2 */
}

/*
Forms
=====
*/

/**
1. Change the font styles in all browsers.
2. Remove the margin in Firefox and Safari.
*/

button,
input,
optgroup,
select,
textarea {
  font-family: inherit; /* 1 */
  font-size: 100%; /* 1 */
  line-height: 1.15; /* 1 */
  margin: 0; /* 2 */
}

/**
Remove the inheritance of text transform in Edge and Firefox.
1. Remove the inheritance of text transform in Firefox.
*/

button,
select { /* 1 */
  text-transform: none;
}

/**
Correct the inability to style clickable types in iOS and Safari.
*/

button,
[type='button'],
[type='reset'],
[type='submit'] {
  -webkit-appearance: button;
}

/**
Remove the inner border and padding in Firefox.
*/

::-moz-focus-inner {
  border-style: none;
  padding: 0;
}

/**
Restore the focus styles unset by the previous rule.
*/

:-moz-focusring {
  outline: 1px dotted ButtonText;
}

/**
Remove the additional ':invalid' styles in Firefox.
See: https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737
*/

:-moz-ui-invalid {
  box-shadow: none;
}

/**
Remove the padding so developers are not caught out when they zero out 'fieldset' elements in all browsers.
*/

legend {
  padding: 0;
}

/**
Add the correct vertical alignment in Chrome and Firefox.
*/

progress {
  vertical-align: baseline;
}

/**
Correct the cursor style of increment and decrement buttons in Safari.
*/

::-webkit-inner-spin-button,
::-webkit-outer-spin-button {
  height: auto;
}

/**
1. Correct the odd appearance in Chrome and Safari.
2. Correct the outline style in Safari.
*/

[type='search'] {
  -webkit-appearance: textfield; /* 1 */
  outline-offset: -2px; /* 2 */
}

/**
Remove the inner padding in Chrome and Safari on macOS.
*/

::-webkit-search-decoration {
  -webkit-appearance: none;
}

/**
1. Correct the inability to style clickable types in iOS and Safari.
2. Change font properties to 'inherit' in Safari.
*/

::-webkit-file-upload-button {
  -webkit-appearance: button; /* 1 */
  font: inherit; /* 2 */
}

/*
Interactive
===========
*/

/*
Add the correct display in Chrome and Safari.
*/

summary {
  display: list-item;
}

/**
 * Manually forked from SUIT CSS Base: https://github.com/suitcss/base
 * A thin layer on top of normalize.css that provides a starting point more
 * suitable for web applications.
 */

/**
 * Removes the default spacing and border for appropriate elements.
 */

blockquote,
dl,
dd,
h1,
h2,
h3,
h4,
h5,
h6,
hr,
figure,
p,
pre {
  margin: 0;
}

button {
  background-color: transparent;
  background-image: none;
}

/**
 * Work around a Firefox/IE bug where the transparent `button` background
 * results in a loss of the default `button` focus styles.
 */

button:focus {
  outline: 1px dotted;
  outline: 5px auto -webkit-focus-ring-color;
}

fieldset {
  margin: 0;
  padding: 0;
}

ol,
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

/**
 * Tailwind custom reset styles
 */

/**
 * 1. Use the user's configured `sans` font-family (with Tailwind's default
 *    sans-serif font stack as a fallback) as a sane default.
 * 2. Use Tailwind's default "normal" line-height so the user isn't forced
 *    to override it to ensure consistency even when using the default theme.
 */

html {
  font-family: proxima-nova, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; /* 1 */
  line-height: 1.5; /* 2 */
}

/**
 * Inherit font-family and line-height from `html` so users can set them as
 * a class directly on the `html` element.
 */

body {
  font-family: inherit;
  line-height: inherit;
}

/**
 * 1. Prevent padding and border from affecting element width.
 *
 *    We used to set this in the html element and inherit from
 *    the parent element for everything else. This caused issues
 *    in shadow-dom-enhanced elements like <details> where the content
 *    is wrapped by a div with box-sizing set to `content-box`.
 *
 *    https://github.com/mozdevs/cssremedy/issues/4
 *
 *
 * 2. Allow adding a border to an element by just adding a border-width.
 *
 *    By default, the way the browser specifies that an element should have no
 *    border is by setting it's border-style to `none` in the user-agent
 *    stylesheet.
 *
 *    In order to easily add borders to elements by just setting the `border-width`
 *    property, we change the default border-style for all elements to `solid`, and
 *    use border-width to hide them instead. This way our `border` utilities only
 *    need to set the `border-width` property instead of the entire `border`
 *    shorthand, making our border utilities much more straightforward to compose.
 *
 *    https://github.com/tailwindcss/tailwindcss/pull/116
 */

*,
::before,
::after {
  box-sizing: border-box; /* 1 */
  border-width: 0; /* 2 */
  border-style: solid; /* 2 */
  border-color: #efefef; /* 2 */
}

/*
 * Ensure horizontal rules are visible by default
 */

hr {
  border-top-width: 1px;
}

/**
 * Undo the `border-style: none` reset that Normalize applies to images so that
 * our `border-{width}` utilities have the expected effect.
 *
 * The Normalize reset is unnecessary for us since we default the border-width
 * to 0 on all elements.
 *
 * https://github.com/tailwindcss/tailwindcss/issues/362
 */

img {
  border-style: solid;
}

textarea {
  resize: vertical;
}

input::placeholder,
textarea::placeholder {
  opacity: 1;
  color: #b9bcc1;
}

button,
[role="button"] {
  cursor: pointer;
}

table {
  border-collapse: collapse;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-size: inherit;
  font-weight: inherit;
}

/**
 * Reset links to optimize for opt-in styling instead of
 * opt-out.
 */

a {
  color: inherit;
  text-decoration: inherit;
}

/**
 * Reset form element properties that are easy to forget to
 * style explicitly so you don't inadvertently introduce
 * styles that deviate from your design system. These styles
 * supplement a partial reset that is already applied by
 * normalize.css.
 */

button,
input,
optgroup,
select,
textarea {
  padding: 0;
  line-height: inherit;
  color: inherit;
}

/**
 * Use the configured 'mono' font family for elements that
 * are expected to be rendered with a monospace font, falling
 * back to the system monospace stack if there is no configured
 * 'mono' font family.
 */

pre,
code,
kbd,
samp {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

/**
 * Make replaced elements `display: block` by default as that's
 * the behavior you want almost all of the time. Inspired by
 * CSS Remedy, with `svg` added as well.
 *
 * https://github.com/mozdevs/cssremedy/issues/14
 */

img,
svg,
video,
canvas,
audio,
iframe,
embed,
object {
  display: block;
  vertical-align: middle;
}

/**
 * Constrain images and videos to the parent width and preserve
 * their instrinsic aspect ratio.
 *
 * https://github.com/mozdevs/cssremedy/issues/14
 */

img,
video {
  max-width: 100%;
  height: auto;
}

body {
  background-color: #f5f5f5;
}

#root {
  overflow: hidden;
}

button:focus,
div[tabindex='-1']:focus {
  outline: 0;
}

a {
  text-decoration: none;
  color: inherit;
}

/* Position Intercom widget below modals and drawers
 * https://material-ui.com/customization/z-index
 */
 .intercom-lightweight-app {
  z-index: 1100 !important;
}


        .makeStyles-timelineArea-7 {
            grid-area: timeline;
        }
        .makeStyles-timeline-24 {
            height: 100%;
            display: flex;
            padding-left: 16px;
            background-color: #36414d;
        }
        .makeStyles-timeline-24 {
            height: 100%;
            display: flex;
            padding-left: 16px;
            background-color: #36414d;
        }
.makeStyles-tickMark-28 {
    height: 100%;
    position: absolute;
}
        .makeStyles-scrollContainer-25 {
            flex: 1;
            height: 100%;
            position: relative;
            overflow-x: scroll;
        }
        .makeStyles-timelineRuler-29 {
            height: 32px;
            position: relative;
            user-select: none;
            border-bottom: 4px solid #737e8c;
            pointer-events: none;
        }
        .makeStyles-tickMark-28 {
            height: 100%;
            position: absolute;
            
        }
        .makeStyles-tickMark-28::after {
            top: 12px;
            left: -1px;
            width: 4px;
            height: 4px;
            content: "";
            position: absolute;
            border-radius: 50%;
            background-color: #737e8c;
        }
        .makeStyles-label-27 {
            top: 5px;
            color: #ffffff;
            position: absolute;
            font-size: 0.75rem;
            background-color: #36414d;
        }
        .makeStyles-cursor-33 {
            top: 32px;
            left: 0;
            width: 2px;
            bottom: 0;
            cursor: col-resize;
            z-index: 40;
            position: absolute;
            background-color: #ffe121;
        }

        .makeStyles-handle-34 {
            top: 0;
            width: 20px;
            height: 20px;
            display: flex;
            position: absolute;
            transform: translate(calc(-50% + 1px), calc(-50% - 2px));
            align-items: center;
            border-radius: 50%;
            justify-content: center;
            background-color: #ffe121;
        }
        .makeStyles-handle-34::before {
            top: 0;
            right: calc(100% - 1px);
            width: 1000vw;
            bottom: 0;
            height: 4px;
            margin: auto;
            content: "";
            position: absolute;
            background-color: #ffe121;
        }

        img, svg, video, canvas, audio, iframe, embed, object {
            display: block;
            vertical-align: middle;
        }
        .makeStyles-tracks-26 {
            top: 40px;
            left: 0;
            position: absolute;
        }
        .makeStyles-timelineTrack-35 {
            height: 32px;
            position: relative;
            border-radius: 4px;
            background-color: #1f2830;
        }
        .makeStyles-timelineTrack-35:not(:last-child) {
            margin-bottom: 4px;
        }
        .makeStyles-timelineTrackLabel-36 {
            color: #ffffff;
            height: 100%;
            display: flex;
            font-size: 0.875rem;
            align-items: center;
            line-height: 1;
            padding-left: 32px;
        }

        .makeStyles-icon-37 {
            font-size: 1rem;
            margin-right: 16px;
        }
        .MuiSvgIcon-root {
            fill: currentColor;
            width: 1em;
            height: 1em;
            display: inline-block;
            font-size: 1.5rem;
            transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
            flex-shrink: 0;
            user-select: none;
        }
        .jss74 {
            color: #ffffff;
            cursor: pointer;
            height: 100%;
            outline: none;
            position: relative;
            background-color: #1f2830;
        }
        .jss77 {
            height: 32px;
            display: flex;
            padding: 0px 8px;
            justify-content: space-between;
        }
        .jss79 {
            display: flex;
        }
        .jss78 {
            width: 1px;
            height: 100%;
            margin: 0px 8px;
            position: relative;
        }
        .jss78::before {
            top: 0;
            width: 100%;
            bottom: 0;
            height: 16px;
            margin: auto;
            content: "";
            position: absolute;
            background-color: #626c78;
        }
        .jss80 {
            color: inherit;
            font-size: 1rem;
            transition: color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        }
        .jss80:disabled {
            color: #626c78;
        }
        .MuiIconButton-root {
            flex: 0 0 auto;
            color: rgba(0, 0, 0, 0.54);
            padding: 8px;
            overflow: visible;
            font-size: 1.5rem;
            text-align: center;
            transition: background-color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
            border-radius: 50%;
        }
        .MuiIconButton-label {
            width: 100%;
            display: flex;
            align-items: inherit;
            justify-content: inherit;
        }
    </style>
    <style>
        .jss60 {
            height: 100%;
            position: relative;
        }
        .jss162 {
            cursor: grab;
            opacity: 1;
            visibility: visible;
        }
        .jss161 {
            border-color: transparent;
        }
        .jss160 {
            z-index: 0;
        }
        .jss101 {
            font-weight: 400;
            border-width: 2px;
            background-color: #626c78;
        }
        .jss97 {
            top: 0;
            color: #ffffff;
            height: 100%;
            position: absolute;
            font-size: 0.75rem;
            box-shadow: 0px 0px 0px 1px rgb(0 0 0 / 10%);
            user-select: none;
            border-style: solid;
            border-radius: 4px;
        }
        .jss100 {
            left: 0;
        }
        .jss94 {
            top: 0;
            width: 12px;
            cursor: ew-resize;
            height: 100%;
            z-index: 1;
            position: absolute;
        }
        .jss94::before {
            top: 0;
            left: 0;
            right: 0;
            width: 3px;
            bottom: 0;
            height: 14px;
            margin: auto;
            content: "";
            position: absolute;
            border-left: 1px solid currentColor;
            border-right: 1px solid currentColor;
        }
        .jss102 {
            width: 100%;
            height: 100%;
            display: flex;
            overflow: hidden;
            align-items: center;
        }
        .jss104 {
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            position: absolute;
            border-radius: 4px;
        }
        .jss94 {
            top: 0;
            width: 12px;
            cursor: ew-resize;
            height: 100%;
            z-index: 1;
            position: absolute;
        }
        .jss94::before {
            top: 0;
            left: 0;
            right: 0;
            width: 3px;
            bottom: 0;
            height: 14px;
            margin: auto;
            content: "";
            position: absolute;
            border-left: 1px solid currentColor;
            border-right: 1px solid currentColor;
        }
        .jss99 {
            right: 0;
            transform: rotate(180deg);
        }
        .jss163 {
            height: 100%;
            position: absolute;
        }
    </style>
    <div id="audio-timeline">
        <div class="MuiBox-root jss66">
            <div class="MuiBox-root jss67">
                <button class="MuiButtonBase-root MuiIconButton-root jss68" tabindex="0" type="button" data-testid="play-pause-button" aria-label="play">
                    <span class="MuiIconButton-label">
                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="2 2 20 20" aria-hidden="true">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 13.5v-7c0-.41.47-.65.8-.4l4.67 3.5c.27.2.27.6 0 .8l-4.67 3.5c-.33.25-.8.01-.8-.4z"></path>
                        </svg>
                    </span>
                </button>
                <div class="MuiBox-root jss70">
                    <div class="jss65">00:01 / <span class="MuiBox-root jss71">00:16</span></div>
                </div>
            </div>
            <button class="MuiButtonBase-root MuiIconButton-root jss62" tabindex="0" type="button" aria-label="mute">
                <span class="MuiIconButton-label">
                    <svg class="sb-icon MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M10.3 2.291 4.37 8.218a.249.249 0 0 1-.177.073H2a2 2 0 0 0-2 2v3.414a2 2 0 0 0 2 2h2.193a.25.25 0 0 1 .177.074l5.93 5.926A1 1 0 0 0 12 21V3a1 1 0 0 0-1.7-.709Zm7.29 2.675a1 1 0 0 0-1.414 1.414 7.944 7.944 0 0 1 0 11.239 1 1 0 0 0 1.414 1.414 9.943 9.943 0 0 0 0-14.067Z"
                        ></path>
                        <path
                            d="M20.041 2.434a1 1 0 0 0-1.414 1.414 11.542 11.542 0 0 1 0 16.3 1 1 0 1 0 1.414 1.414 13.543 13.543 0 0 0 0-19.128Zm-4.9 5.066a1 1 0 1 0-1.416 1.413 4.379 4.379 0 0 1 0 6.179A1 1 0 1 0 15.14 16.5a6.382 6.382 0 0 0 .001-9Z"
                        ></path>
                    </svg>
                </span>
            </button>
        </div>
        <div class="makeStyles-editor-47">
            <div class="makeStyles-stageArea-49">
                <div class="MuiBox-root MuiBox-root-8">
                    <div class="makeStyles-stageControls-50" style="width: 625.778px;">
                        <div>
                            <button class="MuiButtonBase-root MuiIconButton-root makeStyles-button-9" tabindex="0" type="button" aria-label="undo" title="Undo">
                                <span class="MuiIconButton-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" aria-hidden="true">
                                        <defs>
                                            
                                        </defs>
                                        <title>Asset 6</title>
                                        <g id="Layer_2" data-name="Layer 2">
                                            <g id="Layer_1-2" data-name="Layer 1">
                                                <path
                                                    class="cls-1"
                                                    d="M97.1,44.21a4.83,4.83,0,0,0,0-7L79.15,19.81,29.57,68a2.19,2.19,0,0,1-3,0,2,2,0,0,1,0-3l49.58-48.2L64.53,5.6a5.17,5.17,0,0,0-7.14,0L5.76,55.79a4.84,4.84,0,0,0,0,7l2.5,2.43L57.84,17a2.19,2.19,0,0,1,3,0,2,2,0,0,1,0,2.95L11.29,68.12l27,26.28a5.06,5.06,0,0,0,3.56,1.43h0a5.06,5.06,0,0,0,3.56-1.43L97.1,44.21Zm3-9.89a8.9,8.9,0,0,1,0,12.83L50.06,95.83h22.8a2.09,2.09,0,1,1,0,4.17H30a2.09,2.09,0,1,1,0-4.17h3.74l-27-26.24h0l-4-3.91a8.91,8.91,0,0,1,0-12.84L54.35,2.65a9.56,9.56,0,0,1,13.21,0l32.57,31.67ZM51.94,59.22a2.55,2.55,0,0,1-.21,3.27L34.63,79.64a1.91,1.91,0,0,1-1.47.58,1.89,1.89,0,0,1-1.39-.77A2.56,2.56,0,0,1,32,76.18L49.08,59a1.85,1.85,0,0,1,2.86.19Zm-7.1,15.71A2.18,2.18,0,1,1,47.93,78l-7,7A2.19,2.19,0,1,1,37.78,82l7.06-7Zm8.28-5.67a2.35,2.35,0,1,1,3.33,3.33l-1,1a2.35,2.35,0,1,1-3.33-3.33l1-1ZM77,46.1l6.23-6.23-3.12-3.12L73.9,43,77,46.1Zm4.67-14,6.24,6.24a2.21,2.21,0,0,1,0,3.12l-9.35,9.35a2.23,2.23,0,0,1-1.56.65,2.2,2.2,0,0,1-1.56-.65l-6.24-6.24a2.19,2.19,0,0,1,0-3.11l9.36-9.36a2.21,2.21,0,0,1,3.11,0ZM65.22,17.14a2.36,2.36,0,0,1-1.67-4l1-1a2.35,2.35,0,1,1,3.33,3.33l-1,1a2.34,2.34,0,0,1-1.66.69Zm-43.53,55A2.35,2.35,0,1,1,25,75.45l-1,1a2.38,2.38,0,0,1-1.67.69,2.36,2.36,0,0,1-1.67-4l1-1Z"
                                                ></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                            <button class="MuiButtonBase-root MuiIconButton-root makeStyles-button-9" tabindex="0" type="button" aria-label="redo" title="Redo">
                                <span class="MuiIconButton-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" aria-hidden="true">
                                        <defs>
                                            
                                        </defs>
                                        <title>Asset 6</title>
                                        <g id="Layer_2" data-name="Layer 2">
                                            <g id="Layer_1-2" data-name="Layer 1">
                                                <path
                                                    class="cls-1"
                                                    d="M97.1,44.21a4.83,4.83,0,0,0,0-7L79.15,19.81,29.57,68a2.19,2.19,0,0,1-3,0,2,2,0,0,1,0-3l49.58-48.2L64.53,5.6a5.17,5.17,0,0,0-7.14,0L5.76,55.79a4.84,4.84,0,0,0,0,7l2.5,2.43L57.84,17a2.19,2.19,0,0,1,3,0,2,2,0,0,1,0,2.95L11.29,68.12l27,26.28a5.06,5.06,0,0,0,3.56,1.43h0a5.06,5.06,0,0,0,3.56-1.43L97.1,44.21Zm3-9.89a8.9,8.9,0,0,1,0,12.83L50.06,95.83h22.8a2.09,2.09,0,1,1,0,4.17H30a2.09,2.09,0,1,1,0-4.17h3.74l-27-26.24h0l-4-3.91a8.91,8.91,0,0,1,0-12.84L54.35,2.65a9.56,9.56,0,0,1,13.21,0l32.57,31.67ZM51.94,59.22a2.55,2.55,0,0,1-.21,3.27L34.63,79.64a1.91,1.91,0,0,1-1.47.58,1.89,1.89,0,0,1-1.39-.77A2.56,2.56,0,0,1,32,76.18L49.08,59a1.85,1.85,0,0,1,2.86.19Zm-7.1,15.71A2.18,2.18,0,1,1,47.93,78l-7,7A2.19,2.19,0,1,1,37.78,82l7.06-7Zm8.28-5.67a2.35,2.35,0,1,1,3.33,3.33l-1,1a2.35,2.35,0,1,1-3.33-3.33l1-1ZM77,46.1l6.23-6.23-3.12-3.12L73.9,43,77,46.1Zm4.67-14,6.24,6.24a2.21,2.21,0,0,1,0,3.12l-9.35,9.35a2.23,2.23,0,0,1-1.56.65,2.2,2.2,0,0,1-1.56-.65l-6.24-6.24a2.19,2.19,0,0,1,0-3.11l9.36-9.36a2.21,2.21,0,0,1,3.11,0ZM65.22,17.14a2.36,2.36,0,0,1-1.67-4l1-1a2.35,2.35,0,1,1,3.33,3.33l-1,1a2.34,2.34,0,0,1-1.66.69Zm-43.53,55A2.35,2.35,0,1,1,25,75.45l-1,1a2.38,2.38,0,0,1-1.67.69,2.36,2.36,0,0,1-1.67-4l1-1Z"
                                                ></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="makeStyles-playbackControls-14" style="width: 625.778px;">
                        <div class="MuiBox-root MuiBox-root-53">
                            <div class="MuiBox-root MuiBox-root-54">
                                <button class="MuiButtonBase-root MuiIconButton-root makeStyles-button-18" tabindex="0" type="button" data-testid="play-pause-button" aria-label="play"><span class="MuiIconButton-label"></span></button>
                                <div class="MuiBox-root MuiBox-root-55">
                                    <div class="makeStyles-timestamp-15">00:00 / <span class="MuiBox-root MuiBox-root-56">00:00</span></div>
                                </div>
                            </div>
                            <button class="MuiButtonBase-root MuiIconButton-root" tabindex="0" type="button" aria-label="mute" title="Mute">
                                <span class="MuiIconButton-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" aria-hidden="true">
                                        <defs>
                                            
                                        </defs>
                                        <title>Asset 6</title>
                                        <g id="Layer_2" data-name="Layer 2">
                                            <g id="Layer_1-2" data-name="Layer 1">
                                                <path
                                                    class="cls-1"
                                                    d="M97.1,44.21a4.83,4.83,0,0,0,0-7L79.15,19.81,29.57,68a2.19,2.19,0,0,1-3,0,2,2,0,0,1,0-3l49.58-48.2L64.53,5.6a5.17,5.17,0,0,0-7.14,0L5.76,55.79a4.84,4.84,0,0,0,0,7l2.5,2.43L57.84,17a2.19,2.19,0,0,1,3,0,2,2,0,0,1,0,2.95L11.29,68.12l27,26.28a5.06,5.06,0,0,0,3.56,1.43h0a5.06,5.06,0,0,0,3.56-1.43L97.1,44.21Zm3-9.89a8.9,8.9,0,0,1,0,12.83L50.06,95.83h22.8a2.09,2.09,0,1,1,0,4.17H30a2.09,2.09,0,1,1,0-4.17h3.74l-27-26.24h0l-4-3.91a8.91,8.91,0,0,1,0-12.84L54.35,2.65a9.56,9.56,0,0,1,13.21,0l32.57,31.67ZM51.94,59.22a2.55,2.55,0,0,1-.21,3.27L34.63,79.64a1.91,1.91,0,0,1-1.47.58,1.89,1.89,0,0,1-1.39-.77A2.56,2.56,0,0,1,32,76.18L49.08,59a1.85,1.85,0,0,1,2.86.19Zm-7.1,15.71A2.18,2.18,0,1,1,47.93,78l-7,7A2.19,2.19,0,1,1,37.78,82l7.06-7Zm8.28-5.67a2.35,2.35,0,1,1,3.33,3.33l-1,1a2.35,2.35,0,1,1-3.33-3.33l1-1ZM77,46.1l6.23-6.23-3.12-3.12L73.9,43,77,46.1Zm4.67-14,6.24,6.24a2.21,2.21,0,0,1,0,3.12l-9.35,9.35a2.23,2.23,0,0,1-1.56.65,2.2,2.2,0,0,1-1.56-.65l-6.24-6.24a2.19,2.19,0,0,1,0-3.11l9.36-9.36a2.21,2.21,0,0,1,3.11,0ZM65.22,17.14a2.36,2.36,0,0,1-1.67-4l1-1a2.35,2.35,0,1,1,3.33,3.33l-1,1a2.34,2.34,0,0,1-1.66.69Zm-43.53,55A2.35,2.35,0,1,1,25,75.45l-1,1a2.38,2.38,0,0,1-1.67.69,2.36,2.36,0,0,1-1.67-4l1-1Z"
                                                ></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="makeStyles-propertiesArea-51"><div class="makeStyles-closed-23" data-intercom-target="properties-panel"></div></div>
            
            <div class="makeStyles-timelineArea-52" style="height: 240px;">
                <div class="makeStyles-timeline-24" data-intercom-target="timeline">
                    <div class="makeStyles-scrollContainer-25" id="scroll-container">
                        <div class="makeStyles-timelineRuler-29" :style="{width: ruler.width }">
                            <div class="makeStyles-tickMark-28" v-for="(bar, index) in ruler.secondsBars" :data-key="bar.second" :style="{transform: bar.transform, width: bar.width }"></div>
                            {{-- <div class="makeStyles-tickMark-28" style="transform: translateX(298.023px); width: 298.023px;"></div>
                            <div class="makeStyles-tickMark-28" style="transform: translateX(596.046px); width: 298.023px;"></div>
                            <div class="makeStyles-tickMark-28" style="transform: translateX(894.07px); width: 298.023px;"></div>
                            <div class="makeStyles-tickMark-28" style="transform: translateX(1192.09px); width: 298.023px;"></div> --}}
                            <small class="makeStyles-label-27" v-for="(label, labelIndex) in ruler.labels" :data-key="label.seconds" :style="{transform: label.transform}"> @{{label.timestamp}} </small>
                            {{-- <small class="makeStyles-label-27" style="transform: translateX(596.046px) translateX(-50%);"> 0:02 </small> --}}
                            {{-- <small class="makeStyles-label-27" style="transform: translateX(894.07px) translateX(-50%);"> 0:03 </small>
                            <small class="makeStyles-label-27" style="transform: translateX(1192.09px) translateX(-50%);"> 0:04 </small>
                            <small class="makeStyles-label-27" style="transform: translateX(1490.12px) translateX(-50%);"> 0:05 </small> --}}
                        </div>
                        <div class="makeStyles-cursor-33" draggable="true" id="timeline-cursor"  :style="{transform: ruler.cursorTransform}">
                            <div class="makeStyles-handle-34" >
                                <svg width="6" height="12" viewBox="0 0 6 12">
                                    <path d="M1,1V1H1M1,0A1,1,0,0,0,0,1V11a1,1,0,0,0,2,0V1A1,1,0,0,0,1,0Z"></path>
                                    <path d="M5,1V1H5M5,0A1,1,0,0,0,4,1V11a1,1,0,0,0,2,0V1A1,1,0,0,0,5,0Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="makeStyles-tracks-26" :style="{width: ruler.width }">
                            <div class="makeStyles-timelineTrack-35" data-testid="timeline-track-text">
                                <div class="makeStyles-timelineTrackLabel-36">
                                    <svg class="sb-icon MuiSvgIcon-root makeStyles-icon-37" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M24 4.5A1.5 1.5 0 0 0 22.5 3h-3.08a.25.25 0 0 1-.24-.16A4.5 4.5 0 0 0 15 0h-1.5a1 1 0 0 0-1 1v1.75a.25.25 0 0 1-.25.25H2a2 2 0 0 0-2 2v17a2 2 0 0 0 2 2h20.5a1.5 1.5 0 0 0 1.5-1.5Zm-22 1a.5.5 0 0 1 .5-.5h9.75a.25.25 0 0 1 .25.25V16a1 1 0 0 0 1 1H15a2.5 2.5 0 0 1 0 5H2.5a.5.5 0 0 1-.5-.5ZM15 2a2.5 2.5 0 0 1 2.5 2.5v10.82a.24.24 0 0 1-.12.21.25.25 0 0 1-.25 0A4.38 4.38 0 0 0 15 15a.5.5 0 0 1-.5-.5v-12A.5.5 0 0 1 15 2Z"
                                        ></path>
                                        <path
                                            d="M9.28 6.72A.75.75 0 0 0 8 7.25v1a.25.25 0 0 1-.25.25h-3.5a.75.75 0 0 0 0 1.5h3.5a.25.25 0 0 1 .25.25v1a.75.75 0 0 0 1.28.53l2-2a.75.75 0 0 0 0-1.06ZM10.75 17h-3.5a.25.25 0 0 1-.25-.25v-1a.75.75 0 0 0-1.28-.53l-2 2a.75.75 0 0 0 0 1.06l2 2A.75.75 0 0 0 7 19.75v-1a.25.25 0 0 1 .25-.25h3.5a.75.75 0 0 0 0-1.5Z"
                                        ></path>
                                    </svg>
                                    Text &amp; Animation Overlays
                                </div>
                            </div>
                            <div class="makeStyles-timelineTrack-35" data-testid="timeline-track-foreground">
                                <div class="makeStyles-timelineTrackLabel-36">
                                    <svg class="sb-icon MuiSvgIcon-root makeStyles-icon-37" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M2 0h13a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"></path>
                                        <path d="M21.5 7h-2a1 1 0 0 0 0 2h2a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-12a.5.5 0 0 1-.5-.5v-2a1 1 0 0 0-2 0v2A2.5 2.5 0 0 0 9.5 24h12a2.5 2.5 0 0 0 2.5-2.5v-12A2.5 2.5 0 0 0 21.5 7Z"></path>
                                    </svg>
                                    Logos &amp; Image Overlays
                                </div>
                            </div>
                            <div class="makeStyles-timelineTrack-35" data-testid="timeline-track-background">
                                <div class="makeStyles-timelineTrackLabel-36">
                                    <svg class="sb-icon MuiSvgIcon-root makeStyles-icon-37" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M21 0H3a3.0034 3.0034 0 0 0-3 3v18a3.0033 3.0033 0 0 0 3 3h18a3.0034 3.0034 0 0 0 3-3V3a3.0035 3.0035 0 0 0-3-3zm-4.512 13.1211-6.8571 3.8572a1.288 1.288 0 0 1-1.2792-.012 1.287 1.287 0 0 1-.6374-1.1092V8.1429a1.2874 1.2874 0 0 1 1.9166-1.1143l6.8571 3.8571a1.2872 1.2872 0 0 1 .4789 1.7703 1.2872 1.2872 0 0 1-.4789.472v-.0069z"
                                        ></path>
                                    </svg>
                                    Video &amp; Background Images
                                </div>
                            </div>
                            <div class="makeStyles-timelineTrack-35" data-testid="timeline-track-audio">
                                <div class="makeStyles-timelineTrackLabel-36">
                                    <svg class="sb-icon MuiSvgIcon-root makeStyles-icon-37" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M21.6585 0H2.3415A2.3415 2.3415 0 0 0 0 2.3415v19.317A2.3415 2.3415 0 0 0 2.3415 24h19.317A2.3416 2.3416 0 0 0 24 21.6585V2.3415A2.3415 2.3415 0 0 0 21.6585 0zM18.439 13.4634a2.9268 2.9268 0 1 1-2.9268-2.9268c.4033.0003.802.0849 1.1707.2482V7.0244a.294.294 0 0 0-.3512-.2868l-5.8537 1.255a.2928.2928 0 0 0-.2341.2856v7.5267a2.9271 2.9271 0 0 1-3.4978 2.8706 2.9275 2.9275 0 0 1-2.2996-2.2996A2.927 2.927 0 0 1 7.317 12.878c.4032.0004.802.0849 1.1707.2482V8.2759a2.0605 2.0605 0 0 1 1.6191-2.0031l5.8537-1.2539a2.0485 2.0485 0 0 1 2.2792 1.1219 2.048 2.048 0 0 1 .1992.8836v6.439z"
                                        ></path>
                                    </svg>
                                    Audio 1
                                </div>
                            </div>
                            <div class="makeStyles-timelineTrack-35" data-testid="timeline-track-audio-2">
                                
                                <div class="jss60" >
                                    <div class="jss109 jss162" role="button" aria-roledescription="draggable" aria-describedby="DndDescribedBy-0">
                                        <div role="presentation" data-testid="timeline-item" class="jss97 jss160 jss101 jss161" :style="{width: timelineElementWidth + 'px', transform: 'translateX(0px)', left: startTimeOffset + 'px'}">
                                            <div class="jss94 jss100" id="element-left-handle"></div>
                                            <div class="moveHandle jss102">
                                                <div class="jss104">
                                                    <div class="MuiBox-root jss163" style="width: 1674.97px; left: -993.311px;">
                                                        <div style="width: 1674.97px; height: 30px;">
                                                            <div id="waveform"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="jss94 jss99"></div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="makeStyles-timelineTrackLabel-36">
                                    <svg class="sb-icon MuiSvgIcon-root makeStyles-icon-37" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M21.6585 0H2.3415A2.3415 2.3415 0 0 0 0 2.3415v19.317A2.3415 2.3415 0 0 0 2.3415 24h19.317A2.3416 2.3416 0 0 0 24 21.6585V2.3415A2.3415 2.3415 0 0 0 21.6585 0zM18.439 13.4634a2.9268 2.9268 0 1 1-2.9268-2.9268c.4033.0003.802.0849 1.1707.2482V7.0244a.294.294 0 0 0-.3512-.2868l-5.8537 1.255a.2928.2928 0 0 0-.2341.2856v7.5267a2.9271 2.9271 0 0 1-3.4978 2.8706 2.9275 2.9275 0 0 1-2.2996-2.2996A2.927 2.927 0 0 1 7.317 12.878c.4032.0004.802.0849 1.1707.2482V8.2759a2.0605 2.0605 0 0 1 1.6191-2.0031l5.8537-1.2539a2.0485 2.0485 0 0 1 2.2792 1.1219 2.048 2.048 0 0 1 .1992.8836v6.439z"
                                        ></path>
                                    </svg>
                                    Audio 2
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- zoom in and out --}}
                    <div class="makeStyles-container-38">
                        <button class="MuiButtonBase-root MuiButton-root makeStyles-button-39 MuiButton-text" tabindex="0" type="button" @click="zoomOut">
                            <span class="MuiButton-label">
                                <span class="MuiButton-startIcon MuiButton-iconSizeMedium makeStyles-iconSize-40">
                                    <svg class="sb-icon MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 19.5a2.34 2.34 0 0 1-1.73-.78L.46 7.57a1.85 1.85 0 1 1 2.77-2.44l8.58 9.75a.25.25 0 0 0 .38 0l8.58-9.75a1.85 1.85 0 1 1 2.77 2.44l-9.81 11.15a2.34 2.34 0 0 1-1.73.78Z"></path>
                                    </svg>
                                </span>
                                Zoom Out
                            </span>
                        </button>
                        <button class="MuiButtonBase-root MuiButton-root makeStyles-button-39 MuiButton-text" tabindex="0" type="button" @click="zoomIn">
                            <span class="MuiButton-label">
                                <span class="MuiButton-startIcon MuiButton-iconSizeMedium makeStyles-iconSize-40">
                                    <svg class="sb-icon MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 4.5a2.34 2.34 0 0 1 1.73.78l9.81 11.15a1.85 1.85 0 1 1-2.77 2.44l-8.58-9.75a.25.25 0 0 0-.38 0l-8.58 9.75a1.85 1.85 0 1 1-2.77-2.44l9.81-11.15A2.34 2.34 0 0 1 12 4.5Z"></path>
                                    </svg>
                                </span>
                                Zoom In
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/wavesurfer.js"></script>
    <script src="{{URL::asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script type = "text/JavaScript" 
   src = "https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js">
</script>
<script src="{{ asset('js/app/vendors/vue.js') }}"></script>

    <script>
        new Vue({
            el: '#audio-timeline',
            data: {
                basePxPerSecond: 40,
                zoomRate: 1.25,
                projectDuration:100,
                timelineWidth:100,
                timelineEndzone:5,
                windowWidth:0,
                zoom:0,
                maxZoom: 10,
                minZoom: -10,
               
                timelineTimestamp:0,
                ruler:{
                    interval:0,
                    seconds:0,
                    labels:[],
                    width:0,
                    secondsBars:[],
                    cursorTransform: '',
                    cursorIsDragging: false,
                    cursorOffset:0,
                    
                },

                elementDragStart: {
                    current:0
                },
                endTimeOffset: 0,
                moveTimeOffset:0,
                startTimeOffset:0,
                sourceValid:true,
                isTrimmable: true,
                itemWidth:0,
                itemTransform:0,
                itemOffset:0,
                timelineElementWidth:0,
            },
            computed: {},
    
            mounted() {
                const windowWidthInSeconds = this.pixelsToSeconds(this.windowWidth, this.zoom);
                const timelineDuration = Math.ceil(
                    Math.max(this.projectDuration, windowWidthInSeconds) + this.timelineEndzone
                );
                this.timelineWidth = this.secondsToPixels(timelineDuration, this.zoom);
                this.timelineTimestamp = this.getTimelineTimestamp;


                this.initTimelineRuler();
                this.initTimelineCursor();
                var wavesurfer = WaveSurfer.create({
                    container: '#waveform',
                    waveColor: 'violet',
                    progressColor: 'purple'
                });
                wavesurfer.load('audio.mp3');
                this.initTimelineElements();
            },
            computed:{
                getTimelineTimestamp (){
                    if(!this.ruler.cursorIsDragging){
                        let result = this.pixelsToSeconds(this.timelineTimestamp, this.zoom);
                        console.log(result);
                        return result;
                    }else{
                        return this.timelineTimestamp
                    }
                },
            },
            methods: {
                cursorSeek(event){
                    if(this.ruler.cursorIsDragging == true){
                        var offset = $("#timeline-cursor").offset();
                        let deltaX = event.pageX - offset.left;
                        const newOffset = this.ruler.cursorOffset + deltaX;
                        console.log(newOffset);
                        this.ruler.cursorOffset = Math.max(0, newOffset);
                        this.timelineTimestamp = this.getTimelineTimestamp;

                        // this.timelineTimestamp = this.pixelsToSeconds(newOffset, this.zoom);
                        console.log(this.timelineTimestamp);
                        this.ruler.cursorTransform = `translate3d(${this.ruler.cursorOffset}px, 0, 0)`;
                        

                    }
                    
                },
                pixelsToSeconds(pixels = 0, zoom) {
                    const zoomFactor = this.getZoomFactor(zoom);
                    return pixels / zoomFactor;
                },
                secondsToPixels(seconds = 0, zoom) {
                    const zoomFactor = this.getZoomFactor(zoom);
                    return seconds * zoomFactor;
                },
                getZoomFactor(zoom = 0) {
                    return this.basePxPerSecond * Math.pow(this.zoomRate, zoom);
                },
                getInterval(zoom) {
                    // 10s intervals when zoomed far out
                    if (zoom <= -7) {
                        return 10;
                    }
                    // 5s intervals by default
                    if (zoom < 7) {
                        return 5;
                    }
                    // 1s intervals when zoomed in close
                    return 1;
                },
                initTimelineCursor(){
                    let timelineCursor = document.getElementById("timeline-cursor");
                    $( "#timeline-cursor" ).draggable({ 
                        axis: "x",
                        start: ( event, ui ) => {
                            this.ruler.cursorIsDragging = true;
                            console.log(this.ruler.cursorOffset)
                        }, 
                        stop: ( event, ui ) => {
                            this.ruler.cursorIsDragging = false;
                            this.ruler.cursorOffset = this.pixelsToSeconds(this.timelineTimestamp, this.zoom)
                            this.ruler.cursorTransform = `translate3d(${this.ruler.cursorOffset}px, 0, 0)`;



                        }, 
                        drag : this.cursorSeek
                    });
                },
                initTimelineRuler(){
                    const interval = this.getInterval(this.zoom);
                    const seconds = _.range(Math.ceil(this.projectDuration));
                    const labels = _.range(Math.floor(this.projectDuration / interval));
                    this.ruler.width = this.secondsToPixels(this.projectDuration, this.zoom) + 'px';
                    this.ruler.secondsBars = [];
                    this.ruler.labels = [];
                    seconds.map((second) => {
                        const offset = this.secondsToPixels(second, this.zoom);
                        const width = this.secondsToPixels(1, this.zoom) + 'px';
                        const transform = `translateX(${offset}px)`;

                        this.ruler.secondsBars.push({
                            second : second,
                            transform: transform,
                            width: this.ruler.width
                        })
                        // return {
                        //     second : second,
                        //     transform: transform,
                        //     width: this.ruler.width
                        // }
                
                    });

                    labels.map((index) => {
                        const seconds = (index + 1) * interval;
                        const offset = this.secondsToPixels(seconds, this.zoom);
                        const transform = `translateX(${offset}px) translateX(-50%)`;
                        const timestamp = this.formatTimestamp(seconds, {
                                padMinutes: false
                        });
                        this.ruler.labels.push({
                            seconds : seconds,
                            transform: transform,
                            timestamp: timestamp
                        })

                        // return {
                        //     seconds : seconds,
                        //     transform: transform,
                        //     timestamp: timestamp
                        // }
                    
                    });

                },
                formatTimestamp(duration = 0, options = {}) {
                    const {
                        padHours = true,
                            padMinutes = true,
                            padSeconds = true,
                            showMs = false,
                    } = options;

                    const hours = Math.floor(duration / 3600);
                    const minutes = Math.floor(duration / 60) % 60;
                    const seconds = Math.floor(duration % 60);

                    const hh = hours > 0 && padHours ? padZero(hours) : hours;
                    const mm = padMinutes ? _.padStart(minutes, 2, 0) : minutes;
                    const ss = padSeconds ? _.padStart(seconds, 2, 0) : seconds;
                    const ms = showMs && duration.toFixed(2).substr(-2);

                    return `${hh ? `${hh}:` : ''}${mm}:${ss}${ms ? `.${ms}` : ''}`;
                },
                zoomIn() {
                    if(this.canZoomIn()){
                        this.zoom = Math.min(this.zoom + 1, this.maxZoom);
                        this.initTimelineRuler();
                        // this.initTimelineCursor();
                        this.ruler.cursorOffset = this.pixelsToSeconds(this.timelineTimestamp, this.zoom)
                            this.ruler.cursorTransform = `translate3d(${this.ruler.cursorOffset}px, 0, 0)`;
                    }
                },
                zoomOut() {
                    if(this.canZoomOut()){
                        this.zoom = Math.max(this.zoom - 1, this.minZoom);
                        this.initTimelineRuler();
                        // this.initTimelineCursor();
                        this.ruler.cursorOffset = this.pixelsToSeconds(this.timelineTimestamp, this.zoom)
                            this.ruler.cursorTransform = `translate3d(${this.ruler.cursorOffset}px, 0, 0)`;
                    }
                },
                canZoomIn(){
                   return this.zoom < this.maxZoom;
                },
                canZoomOut(zoom){
                    return this.zoom > this.minZoom;
                },
                onCursorDrag(event){
                    console.log(event);
                },
                initTimelineElements(){
                    this.startTimeOffset  = this.secondsToPixels(0, this.zoom)
                    this.endTimeOffset  = this.secondsToPixels(50, this.zoom)
                    this.timelineElementWidth = this.endTimeOffset - this.startTimeOffset;
                    console.log([this.timelineElementWidth, this.endTimeOffset, this.startTimeOffset])
                    let leftHandle = document.getElementById("element-left-handle");
                    $( "#element-left-handle" ).draggable({ 
                        axis: "x",
                        start: ( event, ui ) => {
                            // event.preventDefault();
                            // event.stopPropagation();
                            this.elementDragStart.current = event.screenX; 
                            console.log(event.screenX)
                            
                            
                        }, 
                        stop: ( event, ui ) => {
                           
                            // this.endTimeOffset = 0;
                            // this.moveTimeOffset = 0;
                            // this.startTimeOffset = 0;



                        }, 
                        drag : (event, ui) => {
                            // event.preventDefault();
                            // event.stopPropagation();
                            let timeDelta = this.getDragTimeDelta(event.screenX);
                            let minimumItemDuration = 1;
                            let itemDuration = 50;
                            let itemMaxDuration = 100;
                            let itemTrimStart = 50
                            timeDelta = Math.min(timeDelta, itemDuration - minimumItemDuration);
                            if(itemMaxDuration){
                                timeDelta = Math.max(timeDelta, -itemTrimStart)
                            }
                            this.startTimeOffset = timeDelta;
                            console.log(this.startTimeOffset);
                        }
                    });
                },
                getDragTimeDelta(screenX){
                    return this.pixelsToSeconds(screenX - this.elementDragStart.current, this.zoom);
                }

        }

        
    
        });

        function onCursorDrag(event){
            console.log(event);
        }
    </script>
                    </body>
</html>