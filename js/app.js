var OV;						// OpenVidu object to initialize a session
var session;				// Session object where the user will connect
var publisher;				// Publisher object which the user will publish
var sessionId;				// Unique identifier of the session
var audioEnabled = true;	// True if the audio track of publisher is active
var videoEnabled = true;	// True if the video track of publisher is active
var numOfVideos = 0;		// Keeps track of the number of videos that are being shown

/* OPENVIDU METHODS */

function joinSession() {

	var mySessionId = document.getElementById("sessionId").value;
	var myUserName = document.getElementById("userName").value;

	// --- 1) Get an OpenVidu object ---

	OV = new OpenVidu();

	// --- 2) Init a session ---

	session = OV.initSession();

	// --- 3) Specify the actions when events take place in the session ---

	// On every new Stream received...
	session.on('streamCreated', event => {

		// Subscribe to the Stream to receive it. HTML video will be appended to element with 'video-container' id
		var subscriber = session.subscribe(event.stream, 'video-container');

		// When the HTML video has been appended to DOM...
		subscriber.on('videoElementCreated', event => {

			// Add a new <p> element for the user's nickname just below its video
			appendUserData(event.element, subscriber.stream.connection);
		});
	});

	// On every Stream destroyed...
	session.on('streamDestroyed', event => {

		// Delete the HTML element with the user's nickname. HTML videos are automatically removed from DOM
		removeUserData(event.stream.connection);
	});


	// --- 4) Connect to the session with a valid user token ---

	// 'getToken' method is simulating what your server-side should do.
	// 'token' parameter should be retrieved and returned by your own backend
	getToken(mySessionId).then(token => {

		// First param is the token got from OpenVidu Server. Second param can be retrieved by every user on event
		// 'streamCreated' (property Stream.connection.data), and will be appended to DOM as the user's nickname
		session.connect(token, { clientData: myUserName })
			.then(() => {

				// --- 5) Set page layout for active call ---

				document.getElementById('session-title').innerText = mySessionId;
        		document.getElementById('session-name').innerText = myUserName;
				//document.getElementById('join').style.display = 'none';
				$('#joinModal').modal('hide');
				document.getElementById('session').style.display = 'block';

				
        		
        		// --- 6) Get your own camera stream with the desired properties ---
				                
				publisher = OV.initPublisher('video-container', {
					audioSource: undefined, 	// The source of audio. If undefined default microphone
					videoSource: undefined, 	// The source of video. If undefined default webcam
					publishAudio: false,  		// Whether you want to start publishing with your audio unmuted or not
					publishVideo: true,  		// Whether you want to start publishing with your video enabled or not
					resolution: '1920x1080',  	// The resolution of your video '640x480'
					frameRate: 25,				// The frame rate of your video
					insertMode: 'APPEND',		// How the video is inserted in the target element 'video-container'	
					mirror: true       			// Whether to mirror your local video or not
				});

				// --- 7) Specify the actions when events take place in our publisher ---

				// When our HTML video has been added to DOM...
				publisher.on('videoElementCreated', function (event) {
					initMainVideo(event.element, myUserName);
					appendUserData(event.element, myUserName);
					event.element['muted'] = true;
				});

				// --- 8) Publish your stream ---

				session.publish(publisher);

			})
			.catch(error => {
				console.log('There was an error connecting to the session:', error.code, error.message);
			});
	});
}

function leaveSession() {

	// --- 9) Leave the session by calling 'disconnect' method over the Session object ---
	session.disconnect();

	// Removing all HTML elements with user's nicknames. 
	// HTML videos are automatically removed when leaving a Session
	removeAllUserData();

	// Back to 'Join session' page
	//document.getElementById('joinModal').style.display = 'block';
	document.getElementById('session').style.display = 'none';
	$('#joinModal').modal('show');
}



/* APPLICATION SPECIFIC METHODS */

window.addEventListener('load', function () {
	generateParticipantInfo();
});

window.onbeforeunload = function () {
	if (session) session.disconnect();
};

function generateParticipantInfo() {
	document.getElementById("sessionId").value = "Session A";
	document.getElementById("userName").value = "Participant " + Math.floor(Math.random() * 100);
}

/*
<!-- Remote Video Feeds -->
<div class="col-md-2">
	<div id="client-video-container" class="" alt="Preview"></div>
	<div class="top-centered text-right text-dark p-2" style="z-index:500;">
		<span class="remote-time">10:30 AM</span>
	</div>
	<video class="img-fluid" alt="client-video"></video>
	<div class="bottom-centered bg-secondary text-white p-2">
		<span class="remote-name">Benjamin</span> <span class="remote-title">Scottsdale</span>
		<span class="btn remote-status pull-right"><i class="fas fa-microphone text-success"></i></span>
	</div>
</div>
*/

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
	document.getElementById('video-container').setAttribute("class", "video-container");
	document.getElementById('video-container').setAttribute("id", "data-" + nodeId);
	
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
	dataDiv.className = "bottom-centered bg-secondary text-white p-2";
	dataDiv.id = "remoteData-" + nodeId;

	// 3.
	// Video Div
	videoElement.parentNode.insertBefore(dataDiv, videoElement.nextSibling);
	videoElement.className = "img-fluid";
	videoElement.id = "data-" + nodeId;
	

	// 4.
	// Create Span for Name
	var nameNode = document.createElement('span');
	document.getElementById("remoteData-" + nodeId).appendChild(nameNode);
	nameNode.className = "remote-name";
	nameNode.id = "name-" + nodeId;
	nameNode.innerText = userData + " ";

	// 5.
	// Create Span for Location
	var locationNode = document.createElement('span');
	document.getElementById("remoteData-" + nodeId).appendChild(locationNode);
	locationNode.className = "remote-location";
	locationNode.id = "location-" + nodeId;
	locationNode.innerText = 'Scottsdale ' ;

	// 6.
	// Create Span for Mute
	var locationNode = document.createElement('span');
	document.getElementById("remoteData-" + nodeId).appendChild(locationNode);
	locationNode.className = "remote-status pull-right";
	locationNode.id = "status-" + nodeId;
	//locationNode.innerText = '' ;
	
	// 6.
	// Create Span for Mute
	var locationNode = document.createElement('i');
	document.getElementById("status-" + nodeId).appendChild(locationNode);
	locationNode.className = "fas fa-microphone text-success";
	locationNode.id = "statusI-" + nodeId;
	locationNode.innerText = '' ;


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
	videoElement.addEventListener('click', function () {
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
	//document.querySelector('#main-video p').innerHTML = userData;
	document.getElementById('session-name').innerText = userData ;
	document.querySelector('#main-video video')['muted'] = true;
}

/* AUXILIARY MEHTODS */

function muteAudio() {
	audioEnabled = !audioEnabled;
	publisher.publishAudio(audioEnabled);
	if (!audioEnabled) {
		$('#mute-audio').removeClass('btn-success');
		$('#mute-audio').addClass('btn-danger');
    	$('#change-icons').removeClass('fas fa-microphone fa-9x px-4 m-3');
    	$('#change-icons').addClass('fas fa-microphone-slash fa-7x py-4 m-3');
	} else {
		$('#mute-audio').addClass('btn-success');
		$('#mute-audio').removeClass('btn-danger');
    	$('#change-icons').removeClass('fas fa-microphone-slash fa-7x py-4 m-3');
    	$('#change-icons').addClass('fas fa-microphone fa-9x px-4 m-3');
    	//$('#change-icons').toggleClass('fa-microphone-slash ');
	}

}

function muteVideo() {
	videoEnabled = !videoEnabled;
	publisher.publishVideo(videoEnabled);

	if (!videoEnabled) {
		$('#mute-video').removeClass('btn-primary');
		$('#mute-video').addClass('btn-default');
	} else {
		$('#mute-video').addClass('btn-primary');
		$('#mute-video').removeClass('btn-default');
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
			data: JSON.stringify({ customSessionId: sessionId }),
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
			data: JSON.stringify({ session: sessionId }),
			headers: {
				"Authorization": "Basic " + btoa("OPENVIDUAPP:" + OPENVIDU_SERVER_SECRET),
				"Content-Type": "application/json"
			},
			success: response => resolve(response.token),
			error: error => reject(error)
		});
	});
}