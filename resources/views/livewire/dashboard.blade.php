<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl min-h-[40rem]">

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Random Video Chat aram</h1>
        <div class="mb-4">
            <label for="userSelect" class="block text-sm font-medium mb-2">Select Your ID:</label>
            <select id="userSelect" class="p-2 bg-gray-800 text-white rounded">
                <option value="user1">User 1</option>
                <option value="user2">User 2</option>
                <option value="user3">User 3</option>
                <option value="user4">User 4</option>
                <option value="user5">User 5</option>
            </select>
            <button id="startButton" class="ml-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Start
            </button>
        </div>
        <div class="flex space-x-4">
            <video id="localVideo" autoplay muted playsinline class="w-1/2 bg-gray-800 rounded-lg"></video>
<video id="remoteVideo" autoplay playsinline class="w-1/2 bg-gray-800 rounded-lg"></video>
        </div>
        <button id="changeButton" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Change Partner
        </button>
    </div>
    <script src="https://unpkg.com/peerjs@1.4.7/dist/peerjs.min.js"></script>
    <script>
        // DOM Elements
const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');
const changeButton = document.getElementById('changeButton');
const userSelect = document.getElementById('userSelect');
const startButton = document.getElementById('startButton');

// Variables
let peer; // PeerJS object
let currentPeerConnection = null;
let localStream = null;
const peerList = ['user1', 'user2', 'user3', 'user4', 'user5']; // Predefined peer IDs

// Start button to initialize PeerJS with the selected user ID
startButton.addEventListener('click', () => {
    const selectedUserId = userSelect.value;
    peer = new Peer(selectedUserId); // Initialize PeerJS with the selected user ID

    // Get user media (video and audio)
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then((stream) => {
            localStream = stream;
            localVideo.srcObject = stream;

            // When the PeerJS connection is open, connect to a random peer
            peer.on('open', (id) => {
                console.log('My peer ID is: ' + id);
                connectToRandomPeer();
            });

            // Handle incoming calls
            peer.on('call', (call) => {
                call.answer(localStream); // Answer the call with the local stream
                call.on('stream', (remoteStream) => {
                    remoteVideo.srcObject = remoteStream;
                });
            });

            // Handle peer disconnection
            peer.on('disconnected', () => {
                console.log('Peer disconnected');
                remoteVideo.srcObject = null;
            });

            // Handle errors
            peer.on('error', (error) => {
                console.error('PeerJS error:', error);
            });
        })
        .catch((error) => {
            alert('Error accessing camera/microphone: ' + error.message);

            console.error('Error accessing media devices:', error);
        });
});

// Function to connect to a random peer
function connectToRandomPeer() {
    if (peerList.length === 0) {
        console.log('No peers available to connect.');
        return;
    }

    // Filter out the current user's ID
    const otherPeers = peerList.filter((id) => id !== peer.id);

    if (otherPeers.length === 0) {
        console.log('No other peers available to connect.');
        return;
    }

    // Randomly select a peer ID from the list
    const randomPeerId = otherPeers[Math.floor(Math.random() * otherPeers.length)];

    // Close existing connection if any
    if (currentPeerConnection) {
        currentPeerConnection.close();
    }

    // Connect to the selected peer
    currentPeerConnection = peer.connect(randomPeerId);

    // Handle incoming data connection
    currentPeerConnection.on('open', () => {
        console.log('Connected to peer:', randomPeerId);

        // Call the peer
        const call = peer.call(randomPeerId, localStream);
        call.on('stream', (remoteStream) => {
            remoteVideo.srcObject = remoteStream;
        });
    });

    currentPeerConnection.on('close', () => {
        console.log('Connection closed');
        remoteVideo.srcObject = null;
    });
}

// Change partner button
changeButton.addEventListener('click', () => {
    if (currentPeerConnection) {
        currentPeerConnection.close(); // Close the current connection
    }
    connectToRandomPeer(); // Connect to a new random peer
});
    </script>
</div>
