<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link rel="manifest" href="manifest.json">
    <title>Soundboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div id="activeUsers">0</div>

    <div class="container mt-5 mb-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Soundboard</h2>
            </div>
        </div>

        <!-- Container for Sound Controls and Soundboard -->

        <!-- Row for Sound Controls -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="sound-controls d-flex align-items-center justify-content-between">
                    <button id="stopAllSounds" class="btn btn-warning">Stop All Sounds</button>
                    <div>
                        <label for="volumeSlider" class="form-label me-2">Volume:</label>
                        <input type="range" id="volumeSlider" class="form-range" min="0" max="1" step="0.01"
                            value="0.2">
                    </div>
                </div>
            </div>
        </div>

        <!-- Row for Soundboard -->
        <div class="row">
            <div class="col-12">
                <div class="soundboard">
                    <div id="sound-buttons" class="d-flex flex-wrap justify-content-center">
                        <!-- Sound buttons will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Disclaimer Modal -->
    <div class="modal fade" id="audioDisclaimerModal" tabindex="-1" role="dialog"
        aria-labelledby="audioDisclaimerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="audioDisclaimerModalLabel">Enable Automatic Sound Playback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>To enhance your experience, our website utilizes sound. On certain browsers, you may need to
                        manually enable sound playback. Here's how:</p>
                    <ul>
                        <li><strong>For PC Users:</strong> Click on the website's lock/icon in the address bar. Go to
                            Site settings > Sound, and select "Allow".</li>
                        <li><strong>For Mobile Users:</strong> Due to mobile browser policies, sound may need to be
                            initiated by a user action. Please interact with the site (e.g., click "Enable Sound") to
                            activate audio features.</li>
                    </ul>
                    <p>Please note that settings might vary based on the browser and version. Consult your browser's
                        help section for precise instructions.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div id="toastContainer" style="position: fixed; bottom: 0; right: 0; margin: 20px;">

            <!-- Toast -->
            <div id="soundToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header">
                    <strong class="soundboard-title">Soundboard</strong>
                    <small>Just now</small>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    Sound played successfully!
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>