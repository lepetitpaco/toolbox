<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://lepetitpaco.com/assets/img/wallpaper.png');
            background-color: #8b8b8b;
            /* Fallback color */
            background-size: cover;
            /* Cover the entire page */
            background-position: center;
            /* Center the background image */
            color: #f8f9fa;
            /* Light color for better contrast and readability */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .countdown-container {
            background-color: rgba(55, 49, 77, 0.8);
            padding: 20px;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: auto;
        }

        .time-section {
            text-align: center;
            min-width: 100px;
        }

        .time {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 5px;
        }

        .label {
            font-size: 18px;
            text-transform: uppercase;
        }

        #startCountdown {
            background-color: #0062cc50;
            /* Soft blue */
            border: 1px solid #789;
            /* Slightly darker border for depth */
            color: #fff;
            /* White text for contrast */
            padding: 10px 20px;
            /* Adequate padding */
            font-size: 16px;
            /* Readable font size */
            border-radius: 5px;
            /* Rounded corners for a modern look */
            transition: background-color 0.3s, color 0.3s;
            /* Smooth transition on hover */
        }

        #startCountdown:hover {
            background-color: #678;
            /* Darker shade on hover for interaction feedback */
            color: #dcdcdc;
            /* Slightly lighter text on hover */
        }
    </style>
</head>

<body>
    <div class="countdown-container">
        <form id="countdownForm">
            <input type="text" id="countdownName" class="form-control mb-2" placeholder="Countdown Name" required>
            <input type="time" id="userTime" class="form-control mb-2" required>
            <button type="submit" id="startCountdown" class="btn mb-3">Start</button>
        </form>
        <div id="countdown" class="d-flex justify-content-center">
            <div class="time-section mx-2">
                <span class="time" id="hours">00</span>
                <div class="label">Hours</div>
            </div>
            <div class="time-section mx-2">
                <span class="time" id="minutes">00</span>
                <div class="label">Minutes</div>
            </div>
            <div class="time-section mx-2">
                <span class="time" id="seconds">00</span>
                <div class="label">Seconds</div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            if ("Notification" in window) {
                Notification.requestPermission();
            }
            let countdownInterval;

            $('#countdownForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission behavior

                var userTime = $('#userTime').val();
                var countdownName = $('#countdownName').val();

                startCountdown(userTime, countdownName);

                // Update URL with parameters for persistence
                var newUrl = `${window.location.pathname}?name=${encodeURIComponent(countdownName)}&time=${encodeURIComponent(userTime)}`;
                window.history.pushState({ path: newUrl }, '', newUrl);
            });

            function startCountdown(userTime, countdownName) {
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }

                // Set page title to countdown name
                document.title = `${countdownName}`;


                function updateCountdown() {
                    var currentTime = new Date();
                    var targetTime = new Date(currentTime);
                    var [hours, minutes] = userTime.split(':').map(num => parseInt(num, 10));

                    targetTime.setHours(hours, minutes, 0);

                    if (currentTime > targetTime) {
                        targetTime.setDate(targetTime.getDate() + 1);
                    }

                    var diff = targetTime - currentTime;

                    var hours = Math.floor(diff / (1000 * 60 * 60)).toString().padStart(2, '0');
                    var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                    var seconds = Math.floor((diff % (1000 * 60)) / 1000).toString().padStart(2, '0');

                    if (diff <= 0) {
                        clearInterval(countdownInterval);
                        if ("Notification" in window && Notification.permission === "granted") {
                            new Notification("DRING DRING !!!", {
                                body: `It is ${countdownName}`,
                            });
                        } else {
                            // Fallback for browsers that do not support Notifications or when permission is denied
                            alert(`It is ${countdownName}`);
                        }
                    }

                    $('#hours').text(hours);
                    $('#minutes').text(minutes);
                    $('#seconds').text(seconds);
                }
                updateCountdown(); // Update immediately to avoid delay

                countdownInterval = setInterval(updateCountdown, 1000);
            }

            function checkUrlAndSetCountdown() {
                const urlParams = new URLSearchParams(window.location.search);
                const name = urlParams.get('name');
                const time = urlParams.get('time');

                if (time) {
                    $('#userTime').val(time);
                    $('#countdownName').val(name);
                    startCountdown(time, name);
                }
            }

            checkUrlAndSetCountdown();
        });
    </script>
</body>

</html>