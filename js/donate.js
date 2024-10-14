/*
Author:         Leakfa Team
Author URI:     https://leakfa.com
Version:        1.1.0
*/

const coins = [
    {
        name: "Bitcoin",
        address: "bc1qcggr0e9yse2pmsvkpdxaaf3eg06klu5h7pzdj3",
        qr: "images/donate/btcQR.jpg",
        logo: "images/donate/btcButtonLogo.png"
    },
    {
        name: "Ethereum",
        address: "0xb85298B60AA6A40d4eC462E0Eb8A958d7c735df3",
        qr: "images/donate/ethQR.jpg",
        logo: "images/donate/ethButtonLogo.png"
    },
    {
        name: "BNB",
        address: "0xb85298B60AA6A40d4eC462E0Eb8A958d7c735df3",
        qr: "images/donate/bnbQR.jpg",
        logo: "images/donate/bnbButtonLogo.png"
    },
    {
        name: "TON",
        address: "EQBjfUvqsVTRidYUvA-lahY2NX8HEB2GQrGU7SYlISHA9cCw",
        qr: "images/donate/tonQR.jpg",
        logo: "images/donate/tonButtonLogo.png"
    },
    {
        name: "Litecoin",
        address: "ltc1q0zyrmlrxyjf266ha3kdnanzkaclvv357faq8e3",
        qr: "images/donate/ltcQR.jpg",
        logo: "images/donate/ltcButtonLogo.png"
    },
    {
        name: "Tron",
        address: "TTgkifzuHTeoV1wPvzvdnejUpEvmxkzgi2",
        qr: "images/donate/trxQR.jpg",
        logo: "images/donate/trxButtonLogo.png"
    },
    {
        name: "USDT (TRC20)",
        address: "TTgkifzuHTeoV1wPvzvdnejUpEvmxkzgi2",
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
