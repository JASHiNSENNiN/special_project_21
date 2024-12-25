<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="image/W.png">
    <title>Woriky Verification</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .wait {
        margin-bottom: 20px;
        color: #333;
        margin-top: 10%;
        width: 100%;
        text-align: center;
    }

    .wait1 {
        margin-bottom: 20px;
        color: #333;
        /* margin-top: 10%; */
        width: 100%;
        text-align: center;
    }

    .message {
        font-size: 20px;
        color: #555;
        text-align: center;
        margin-bottom: 40px;
    }

    .nav-header {
        background-color: #fff;
        padding-right: 20px;
        padding-left: 100px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .logo img {
        width: 220px;
        margin-right: 30px;
    }

    .container {
        width: 100vw;
        height: 100vh;
        background: #ffffff;
        border: 1px solid white;
        position: relative;
        /* Make sure the container is relative */
    }

    .confetti-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
    }

    .confetti {
        position: absolute;
        z-index: 1;
        top: -10px;
        border-radius: 0%;
        width: 10px;
        height: 10px;
    }

    /* Confetti Animations */
    .confetti--animation-slow {
        animation: confetti-slow 2.25s linear 1 forwards;
    }

    .confetti--animation-medium {
        animation: confetti-medium 1.75s linear 1 forwards;
    }

    .confetti--animation-fast {
        animation: confetti-fast 1.25s linear 1 forwards;
    }

    @keyframes confetti-slow {
        0% {
            transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
        }

        100% {
            transform: translate3d(25px, 105vh, 0) rotateX(360deg) rotateY(180deg);
        }
    }

    @keyframes confetti-medium {
        0% {
            transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
        }

        100% {
            transform: translate3d(100px, 105vh, 0) rotateX(100deg) rotateY(360deg);
        }
    }

    @keyframes confetti-fast {
        0% {
            transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
        }

        100% {
            transform: translate3d(-50px, 105vh, 0) rotateX(10deg) rotateY(250deg);
        }
    }

    /* Checkmark Styles */
    .checkmark-circle {
        width: 150px;
        height: 150px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin-left: auto;
        margin-right: auto;
    }

    .checkmark-circle .background {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #00C09D;
        position: absolute;
    }

    .checkmark-circle .checkmark {
        border-radius: 5px;
    }

    .submit-btn {
        height: 45px;
        width: 200px;
        font-size: 15px;
        background-color: #00c09d;
        border: 1px solid #00ab8c;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: all .2s ease-out;
    }

    .submit-btn:hover {
        background-color: #2ca893;
        transition: all .2s ease-out;
    }

    .icon {
        width: 50px;
        height: 50px;
        background-image: url('checkmark-icon.png');
        /* Replace with your icon */
        background-size: cover;
        margin: 20px auto;
    }

    .go-home-button {
        background: linear-gradient(135deg, #28a745, #218838);
        /* Gradient background */
        color: white;
        /* Text color */
        border: none;
        /* Remove border */
        padding: 15px 30px;
        /* Padding for the button */
        border-radius: 8px;
        /* More rounded corners */
        font-size: 18px;
        /* Font size */
        cursor: pointer;
        /* Pointer cursor */
        transition: background-color 0.3s ease, transform 0.2s ease;
        /* Smooth transitions */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Shadow for depth */
        text-align: center;
        margin: auto;
        width: auto;
    }

    .go-home-button:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        /* Darker gradient on hover */
        transform: translateY(-3px);
        /* Slight lift effect on hover */
    }

    .go-home-button:active {
        transform: translateY(1px);
        /* Pressed effect */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        /* Reduce shadow when pressed */
    }

    nav {
        text-align: center;
        display: flex;
        margin-right: 180px;
    }

    nav a {
        color: #000000;
        text-decoration: none;
        padding: 10px 20px;
        margin: 0 10px;
        border-radius: 5px;
        position: relative;
        transition: background-color 0.3s;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
    }

    nav .login-btn:hover {
        color: #172738;
    }

    nav a:hover {
        color: #000000;
        /* background-color: rgba(27, 188, 155, 0.3); */
        font-weight: bold;
    }
    </style>
</head>

<body>
    <header class="nav-header">
        <div class="logo">
            <a href="#">
                <img src="image/logov3.jpg" alt="Logo">
            </a>
        </div>
    </header>
    <div class="js-container container">
        <div class="wame">
            <h1 class="wait">Congratulations!</h1>
            <h3 class="wait1">(Student Name)</h3>
            <p class="message">You have successfully completed your work immersion.</p>
            <p class="message" style="margin-top:-15px;">We are proud of your hard work and dedication. This is just the
                beginning of your bright
                future! <br><button class="go-home-button" style="margin-top:50px;" onclick="goHome()">View
                    Result</button></p>

        </div>
    </div>

    <script>
    // Optional: Add functionality to redirect to the home page
    function goHome() {
        window.location.href = "profile.html"; // Replace with the actual home page URL
    }
    </script>
    <script>
    const Confettiful = function(el) {
        this.el = el;
        this.containerEl = null;
        this.confettiFrequency = 3;
        this.confettiColors = ['#EF2964', '#00C09D', '#2D87B0', '#48485E', '#EFFF1D'];
        this.confettiAnimations = ['slow', 'medium', 'fast'];

        this._setupElements();
        this._renderConfetti();
    };

    Confettiful.prototype._setupElements = function() {
        const containerEl = document.createElement('div');
        containerEl.classList.add('confetti-container');
        this.el.appendChild(containerEl);
        this.containerEl = containerEl;
    };

    Confettiful.prototype._renderConfetti = function() {
        this.confettiInterval = setInterval(() => {
            const confettiEl = document.createElement('div');
            const confettiSize = (Math.floor(Math.random() * 3) + 7) + 'px';
            const confettiBackground = this.confettiColors[Math.floor(Math.random() * this.confettiColors
                .length)];
            const confettiLeft = (Math.floor(Math.random() * this.el.offsetWidth)) + 'px';
            const confettiAnimation = this.confettiAnimations[Math.floor(Math.random() * this
                .confettiAnimations.length)];

            confettiEl.classList.add('confetti', 'confetti--animation-' + confettiAnimation);
            confettiEl.style.left = confettiLeft;
            confettiEl.style.width = confettiSize;
            confettiEl.style.height = confettiSize;
            confettiEl.style.backgroundColor = confettiBackground;

            confettiEl.removeTimeout = setTimeout(function() {
                confettiEl.parentNode.removeChild(confettiEl);
            }, 3000);

            this.containerEl.appendChild(confettiEl);
        }, 25);
    };

    window.confettiful = new Confettiful(document.querySelector('.js-container'));
    </script>
</body>

</html>