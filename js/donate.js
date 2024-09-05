/*
Author:         Leakfa Team
Author URI:     https://leakfa.com
Version:        1.0.0
*/

const coins = [
    {
        name: "Bitcoin",
        address: "bc1qacqns7cvsr3t7nm6tlpamss7xnk7yffqtl6ydx",
        qr: "images/donate/btcQR.jpg",
        logo: "images/donate/btcButtonLogo.png"
    },
    {
        name: "Ethereum",
        address: "0x7Ecb682B67610DE8e59cB0b8897c6FF56566216f",
        qr: "images/donate/ethQR.jpg",
        logo: "images/donate/ethButtonLogo.png"
    },
    {
        name: "BNB",
        address: "0x7Ecb682B67610DE8e59cB0b8897c6FF56566216f",
        qr: "images/donate/bnbQR.jpg",
        logo: "images/donate/bnbButtonLogo.png"
    },
    {
        name: "TON",
        address: "EQAOQ3bt03RbvhrjD4ojTX9NgyJGrC80wOGhkj1KK1KYmoNt",
        qr: "images/donate/tonQR.jpg",
        logo: "images/donate/tonButtonLogo.png"
    },
    {
        name: "Litecoin",
        address: "ltc1q40mq9250eawwjnw4wrqe4zc9ese7cz37rj86rq",
        qr: "images/donate/ltcQR.jpg",
        logo: "images/donate/ltcButtonLogo.png"
    },
    {
        name: "USDT (TRC20)",
        address: "TQBqd7fMz4Af4Co9V8QJwx5DMDiDxgxtAv",
        qr: "images/donate/usdtQR.jpg",
        logo: "images/donate/usdtButtonLogo.png"
    },
];

let currentCoinIndex = 0;

function updateDisplay() {
    const coinLogo = document.getElementById('coin-logo');
    const addressText = document.getElementById('address-text');
    const qr = document.getElementById('qr');
    const copyMessage = document.getElementById('copy-message');

    coinLogo.src = coins[currentCoinIndex].logo;
    coinLogo.alt = coins[currentCoinIndex].name;
    addressText.value = coins[currentCoinIndex].address;
    qr.src = coins[currentCoinIndex].qr;
    qr.alt = `${coins[currentCoinIndex].name} QR Code`;

    // Hide the copied message when updating
    copyMessage.style.opacity = 0;
}

function prevCoin() {
    currentCoinIndex = (currentCoinIndex === 0) ? coins.length - 1 : currentCoinIndex - 1;
    updateDisplay();
}

function nextCoin() {
    currentCoinIndex = (currentCoinIndex === coins.length - 1) ? 0 : currentCoinIndex + 1;
    updateDisplay();
}

function copyAddress() {
    const addressText = document.getElementById('address-text');
    const copyMessage = document.getElementById('copy-message');

    addressText.select();
    addressText.setSelectionRange(0, 99999);  // For mobile devices

    // Copy the text inside the text field
    document.execCommand('copy');

    // Show the "Copied!" message
    copyMessage.style.opacity = 1;

    // Hide the message after 2 seconds
    setTimeout(() => {
        copyMessage.style.opacity = 0;
    }, 2000);
}

// Initialize the widget with the first coin
updateDisplay();
