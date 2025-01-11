<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" type="text/css" href="css/Congratulatio.css">
    <title>Woriky Verification</title>
</head>

<body>
    <header class="nav-header">
        <div class="logo">
            <a href="#">
                <img src="image/drdsnhs.svg" alt="Logo">
            </a>
        </div>
    </header>
    <div class="js-container container">
        <div class="wame">
            <h1 class="wait">Congratulations!</h1>
            <h3 class="wait1">(Student Name)</h3>
            <p class="message">You have successfully completed your work immersion.</p>
            <p class="message" style="margin-top:-15px;">We are proud of your hard work and dedication. This is just the
                beginning of your bright future!</p>

            <!-- <button class="go-home-button" style="margin-top:50px; cursor:pointer;" onclick="goHome()">View
                Result</button> -->

            <p id="countdown" class="message" style="margin-top:15px;">Redirecting to your Result <br> <span
                    id="timer">15</span>
                seconds.</p>
        </div>
    </div>

    <script>
        function goHome() {
            window.location.href = "Profile.php";
        }


        let countdownTime = 15;
        const timerDisplay = document.getElementById('timer');

        const countdownInterval = setInterval(() => {
            countdownTime--;
            timerDisplay.textContent = countdownTime;

            if (countdownTime <= 0) {
                clearInterval(countdownInterval);
                goHome();
            }
        }, 1000);
    </script>
    <script>
        const Confettiful = function (el) {
            this.el = el;
            this.containerEl = null;
            this.confettiFrequency = 3;
            this.confettiColors = ['#EF2964', '#00C09D', '#2D87B0', '#48485E', '#EFFF1D'];
            this.confettiAnimations = ['slow', 'medium', 'fast'];

            this._setupElements();
            this._renderConfetti();
        };

        Confettiful.prototype._setupElements = function () {
            const containerEl = document.createElement('div');
            containerEl.classList.add('confetti-container');
            this.el.appendChild(containerEl);
            this.containerEl = containerEl;
        };

        Confettiful.prototype._renderConfetti = function () {
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

                confettiEl.removeTimeout = setTimeout(function () {
                    confettiEl.parentNode.removeChild(confettiEl);
                }, 3000);
                this.containerEl.appendChild(confettiEl);
            }, 25);
        };

        window.confettiful = new Confettiful(document.querySelector('.js-container'));
    </script>
</body>

</html>