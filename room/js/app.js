var OV; // OpenVidu object to initialize a session
var session; // Session object where the user will connect
var publisher; // Publisher object which the user will publish
var sessionId; // Unique identifier of the session
var audioEnabled = false; // True if the audio track of publisher is active
var videoEnabled = true; // True if the video track of publisher is active
var numOfVideos = 0; // Keeps track of the number of videos that are being shown

// Check if the URL already has a room
window.addEventListener('load', function () {
	sessionId = window.location.hash.slice(1); // For 'https://myurl/#roomId', sessionId would be 'roomId'
	if (sessionId) {
		// The URL has a session id. Join the room right away
		console.log("Joining to room " + sessionId);
		showSessionHideJoin();
		joinRoom();
	} else {
		// The URL has not a session id. Show welcome page
		showJoinHideSession();
	}
});

// Disconnect participant on browser's window closed
window.addEventListener('beforeunload', function () {
	if (session) session.disconnect();
});


/* OPENVIDU METHODS */
function joinRoom() {
	var mySessionId = document.getElementById("sessionId").value;
	var myUserName = document.getElementById("userName").value;
	var myEmailId = document.getElementById("userEmail").value;

	if (!sessionId) {
		// If the user is joining to a new room
		sessionId = document.getElementById("sessionId").value; //randomString();
	}

	// --- 1) Get an OpenVidu object ---
	OV = new OpenVidu();

	// --- 2) Init a session ---
	session = OV.initSession();

	// --- 3) Specify the actions when events take place in the session ---
	
	// Get Available Devices and list for user selection
	OV.getDevices().then(devices => {
		console.log('Available Devices: ', devices);
		// 'devices' array contains all available media devices
		var videoDevices = devices.filter(device => device.kind === 'videoinput');
    	if (videoDevices && videoDevices.length > 1) {
        	var VideoSource = videoDevices[0].deviceId;
        	console.log('1st Video Device: ', videoDevices[0].deviceId);
        }
	});

	// On every new Stream received...
	session.on('streamCreated', function (event) {
		// Subscribe to the Stream to receive it. HTML video will be appended to element with 'subscriber' id
		var subscriber = session.subscribe(event.stream, 'videos');
		// When the new video is added to DOM, update the page layout to fit one more participant
		subscriber.on('videoElementCreated', function (event) {
        	clientData: myUserName
			numOfVideos++;
			updateLayout();
        	appendUserData(event.element, myUserName);
		});
	});

	// On every new Stream destroyed...
	session.on('streamDestroyed', function (event) {
		// Update the page layout
		numOfVideos--;
		updateLayout();
	});

	// --- 4) Connect to the session with a valid user token ---

	// 'getToken' method is simulating what your server-side should do.
	// 'token' parameter should be retrieved and returned by your own backend
	getToken(sessionId).then(token => {

		// First param is the token got from OpenVidu Server. Second param can be retrieved by every user on event
		// 'streamCreated' (property Stream.connection.data), and will be appended to DOM as the user's nickname
		session.connect(token, {
				clientData: myUserName
			})
			.then(() => {

				// --- 5) Set page layout for active call ---
				document.getElementById('session-title').innerText = mySessionId;
				document.getElementById('session-name').innerText = myUserName;
        		$('#joinModal').modal('hide');
				document.getElementById('session').style.display = 'block';
				
				// Update the URL shown in the browser's navigation bar to show the session id
				var path = (location.pathname.slice(-1) == "/" ? location.pathname : location.pathname + "/");
				window.history.pushState("", "", path + '#' + sessionId);

				// Auxiliary methods to show the session's view
				showSessionHideJoin();
				initializeSessionView();
        
				// --- 6) Get your own camera stream with the desired properties ---

				publisher = OV.initPublisher('local-video-container', {
					audioSource: undefined, // The source of audio. If undefined default microphone
					videoSource: undefined, // The source of video. If undefined default webcam
					publishAudio: false, // Whether you want to start publishing with your audio unmuted or not
					publishVideo: true, // Whether you want to start publishing with your video enabled or not
					resolution: '1920x1080', // The resolution of your video '640x480'
					frameRate: 25, // The frame rate of your video
					insertMode: 'APPEND', // How the video is inserted in the target element 'video-container'	
					mirror: true // Whether to mirror your local video or not
				});

				// --- 7) Specify the actions when events take place in our publisher ---

				// When our HTML video has been added to DOM...
				publisher.on('videoElementCreated', function(event) {
					initMainVideo(event.element, myUserName);
					appendUserData(event.element, myUserName);					
                	numOfVideos++;
					//updateLayout();
					$(event.element).prop('muted', true); // Mute local video to avoid feedback
				});

				// --- 8) Publish your stream ---
				session.publish(publisher);

			})
			.catch(error => {
				console.log('There was an error connecting to the session:', error.code, error.message);
			});
	});
}

function leaveRoom() {
	// --- 9) Leave the session by calling 'disconnect' method over the Session object ---
	session.disconnect();
	// Back to welcome page
	window.location.href = window.location.origin + window.location.pathname;
}


function appendUserData(videoElement, connection) {
	var userData;
	var nodeId;
	if (typeof connection === "string") {
		userData = connection;
		nodeId = connection;
	} else {
		userData = JSON.parse(connection.data).clientData;
		nodeId = connection.connectionId;
	}

	// ADD ID to video container
	document.getElementById('local-video-container').setAttribute("class", "video-container");
	document.getElementById('local-video-container').setAttribute("id", "data-" + nodeId);

	// 1.
	// Create Div for Time
	var timeDiv = document.createElement('div');
	timeDiv.className = "top-centered text-right text-dark p-2 remote-time";
	timeDiv.style = "z-index:500;"
	timeDiv.id = "time-" + nodeId;
	timeDiv.innerHTML = '10:30 AM';
	//timeDiv.appendChild("data-" + nodeId);

	// 2.
	// Div for Name and Mute Status
	var dataDiv = document.createElement('div');
	dataDiv.className = "row bottom-centered bg-secondary text-white p-2 mx-0";
	dataDiv.id = "remoteData-" + nodeId;

	// 3.
	// Video Div
	videoElement.parentNode.insertBefore(dataDiv, videoElement.nextSibling);
	videoElement.className = "video";
	videoElement.id = "data-" + nodeId;


	// 4.
	// Create Div for
	var nameNodeDiv = document.createElement('div');
	nameNodeDiv.className = "col px-0 mx-0 d-sm-none d-md-block text-left";
	nameNodeDiv.id = "nameNodeDiv";
	document.getElementById("remoteData-" + nodeId).appendChild(nameNodeDiv);
	// Create Span for Name
	var nameNode = document.createElement('span');
	nameNode.className = "remote-name";
	nameNode.id = "name-" + nodeId;
	nameNode.innerText = userData + " ";
	$(nameNode).appendTo(nameNodeDiv);

	// 5.
	// Create Div for
	var locationNodeDiv = document.createElement('div');
	locationNodeDiv.className = "col px-0 mx-0 d-sm-none d-md-block text-center";
	locationNodeDiv.id = "locationNodeDiv";
	document.getElementById("remoteData-" + nodeId).appendChild(locationNodeDiv);
	// Create Span for Location
	var locationNode = document.createElement('span');
	locationNode.className = "remote-location";
	locationNode.id = "location-" + nodeId;
	locationNode.innerText = 'Scottsdale ';
	$(locationNode).appendTo(locationNodeDiv);

	// 6.
	// Create Div for Mute
	var statusNodeDiv = document.createElement('div');
	statusNodeDiv.className = "col-2 px-0 mx-0 d-sm-none d-md-block text-right pr-1";
	statusNodeDiv.id = "statusNodeDiv";
	document.getElementById("remoteData-" + nodeId).appendChild(statusNodeDiv);
	// Create Span for Mute
	var statusNode = document.createElement('span');
	statusNode.className = "remote-status pull-right";
	statusNode.id = "status-" + nodeId;
	//statusNode.innerText = '' ;
	$(statusNode).appendTo(statusNodeDiv);

	// 6.
	// Create Span for Mute
	var statusNodei = document.createElement('i');
	$(statusNodei).appendTo(statusNodeDiv);
	statusNodei.className = "fas fa-microphone text-success";
	statusNodei.id = "statusI-" + nodeId;
	statusNodei.innerText = '';


	addClickListener(videoElement, userData);
}



function removeUserData(connection) {
	var dataNode = document.getElementById("data-" + connection.connectionId);
	dataNode.parentNode.removeChild(dataNode);
}

function removeAllUserData() {
	var nicknameElements = document.getElementsByClassName('data-node');
	while (nicknameElements[0]) {
		nicknameElements[0].parentNode.removeChild(nicknameElements[0]);
	}
}

function addClickListener(videoElement, userData) {
	videoElement.addEventListener('click', function() {
		var mainVideo = $('#main-video video').get(0);
		if (mainVideo.srcObject !== videoElement.srcObject) {
			$('#main-video').fadeOut("fast", () => {
				document.getElementById('session-name').innerText = userData;
				mainVideo.srcObject = videoElement.srcObject;
				$('#main-video').fadeIn("fast");
			});
		}
	});
}

function initMainVideo(videoElement, userData) {
	document.querySelector('#main-video video').srcObject = videoElement.srcObject;
	document.getElementById('session-name').innerText = userData;
	document.querySelector('#main-video video')['muted'] = true;
}

/* AUXILIARY MEHTODS */

function muteAudio() {
	audioEnabled = !audioEnabled;
	publisher.publishAudio(audioEnabled);
	if (!audioEnabled) {
		$('#mute-audio').removeClass('btn-success');
		$('#mute-audio').addClass('btn-danger');
		$('#audio-icons').removeClass('fas fa-microphone fa-8x px-3 m-3');
		$('#audio-icons').addClass('fas fa-microphone-slash fa-6x py-3 m-3');
	} else {
		$('#mute-audio').addClass('btn-success');
		$('#mute-audio').removeClass('btn-danger');
		$('#audio-icons').removeClass('fas fa-microphone-slash fa-6x py-3 m-3');
		$('#audio-icons').addClass('fas fa-microphone fa-8x px-3 m-3');
		//$('#change-icons').toggleClass('fa-microphone-slash ');
	}
}

function muteVideo() {
	videoEnabled = !videoEnabled;
	publisher.publishVideo(videoEnabled);

	if (!videoEnabled) {
    	$('#mute-video').removeClass('btn-success');
    	$('#mute-video').addClass('btn-danger');
		$('#video-icons').removeClass('fas fa-video fa-2x py-2 m-1');
		$('#video-icons').addClass('fas fa-video-slash fa-2x py-2 m-1');
	} else {
		$('#mute-video').addClass('btn-success');
    	$('#mute-video').removeClass('btn-danger');
    	$('#video-icons').removeClass('fas fa-video-slash fa-2x py-2 m-1');
		$('#video-icons').addClass('fas fa-video fa-2x py-2 m-1');
	}
}

//function randomString() {
//	return Math.random().toString(36).slice(2);
//}

/* APPLICATION SPECIFIC METHODS */
window.addEventListener('load', function() {
	generateParticipantInfo();
});

window.onbeforeunload = function() {
	if (session) session.disconnect();
};

function generateParticipantInfo() {
	document.getElementById("sessionId").value = Math.random().toString(36).slice(2); //"Session A";
	document.getElementById("userName").value = "Participant " + Math.floor(Math.random() * 100);
}

// 'Session' page
function showSessionHideJoin() {
	$('#joinModal').modal('hide');
	document.getElementById('session').style.display = 'block';
	//$('#main-container').removeClass('container');
}

// 'Join' page 
function showJoinHideSession() {
	$('#joinModal').modal('show');
	document.getElementById('session').style.display = 'none';
	$('#joinModal').modal('show');
}

// Prepare HTML dynamic elements (URL clipboard input)
function initializeSessionView() {
	// Tooltips
	$('[data-toggle="tooltip"]').tooltip();
	// Input clipboard
	$('#copy-input').val(window.location.href);
	$('#copy-button').bind('click', function () {
		var input = document.getElementById('copy-input');
		input.focus();
		input.setSelectionRange(0, input.value.length);
		try {
			var success = document.execCommand('copy');
			if (success) {
				$('#copy-button').trigger('copied', ['Copied!']);
			} else {
				$('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
			}
		} catch (err) {
			$('#copy-button').trigger('copied', ['Copy with Ctrl-c']);
		}
	});

	// Handler for updating the tooltip message.
	$('#copy-button').bind('copied', function (event, message) {
		$(this).attr('title', message)
			.tooltip('fixTitle')
			.tooltip('show')
			.attr('title', "Copy to Clipboard")
			.tooltip('fixTitle');
	});
}


// Dynamic layout adjustemnt depending on number of videos
function updateLayout() {
	console.warn('There are now ' + numOfVideos + ' videos');

	var publisherDiv = $('#publisher');
	var publisherVideo = $("#publisher video");
	var subscriberVideos = $('#videos > video');

	publisherDiv.removeClass();
	publisherVideo.removeClass();
	subscriberVideos.removeClass();

	switch (numOfVideos) {
		case 1:
			publisherVideo.addClass('video1');
			break;
		case 2:
			publisherDiv.addClass('video2');
			subscriberVideos.addClass('video2');
			break;
		case 3:
			publisherDiv.addClass('video3');
			subscriberVideos.addClass('video3');
			break;
		case 4:
			publisherDiv.addClass('video4');
			publisherVideo.addClass('video4');
			subscriberVideos.addClass('video4');
			break;
		default:
			publisherDiv.addClass('videoMore');
			publisherVideo.addClass('videoMore');
			subscriberVideos.addClass('videoMore');
			break;
	}
}

/**
 * --------------------------
 * SERVER-SIDE RESPONSIBILITY
 * --------------------------
 * These methods retrieve the mandatory user token from OpenVidu Server.
 * This behavior MUST BE IN YOUR SERVER-SIDE IN PRODUCTION (by using
 * the API REST, openvidu-java-client or openvidu-node-client):
 *   1) Initialize a session in OpenVidu Server	(POST /api/sessions)
 *   2) Generate a token in OpenVidu Server		(POST /api/tokens)
 *   3) The token must be consumed in Session.connect() method
 */

//var OPENVIDU_SERVER_URL = "https://" + location.hostname + ":4443";
//var OPENVIDU_SERVER_SECRET = "MY_SECRET";

var OPENVIDU_SERVER_URL = "https://conference.bisonconstructions.com.au:4443";
var OPENVIDU_SERVER_SECRET = "EaT5dcFY2";

function getToken(mySessionId) {
	return createSession(mySessionId).then(sessionId => createToken(sessionId));
}

function createSession(sessionId) { // See https://openvidu.io/docs/reference-docs/REST-API/#post-apisessions
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "POST",
			url: OPENVIDU_SERVER_URL + "/api/sessions",
			data: JSON.stringify({
				customSessionId: sessionId
			}),
			headers: {
				"Authorization": "Basic " + btoa("OPENVIDUAPP:" + OPENVIDU_SERVER_SECRET),
				"Content-Type": "application/json"
			},
			success: response => resolve(response.id),
			error: (error) => {
				if (error.status === 409) {
					resolve(sessionId);
				} else {
					console.warn('No connection to OpenVidu Server. This may be a certificate error at ' + OPENVIDU_SERVER_URL);
					if (window.confirm('No connection to OpenVidu Server. This may be a certificate error at \"' + OPENVIDU_SERVER_URL + '\"\n\nClick OK to navigate and accept it. ' +
							'If no certificate warning is shown, then check that your OpenVidu Server is up and running at "' + OPENVIDU_SERVER_URL + '"')) {
						location.assign(OPENVIDU_SERVER_URL + '/accept-certificate');
					}
				}
			}
		});
	});
}

function createToken(sessionId) { // See https://openvidu.io/docs/reference-docs/REST-API/#post-apitokens
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "POST",
			url: OPENVIDU_SERVER_URL + "/api/tokens",
			data: JSON.stringify({
				session: sessionId
			}),
			headers: {
				"Authorization": "Basic " + btoa("OPENVIDUAPP:" + OPENVIDU_SERVER_SECRET),
				"Content-Type": "application/json"
			},
			success: response => resolve(response.token),
			error: error => reject(error)
		});
	});
}