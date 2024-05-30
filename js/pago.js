document.querySelector('.btn-pagar').addEventListener('submit', function (e) {
    e.preventDefault();
    const cardNumber = document.getElementById('card-number').value;
    const expiryDate = document.getElementById('expiry-date').value;
    const cvv = document.getElementById('cvv').value;

    if (validateCardDetails(cardNumber, expiryDate, cvv)) {
        e.target.form.submit();
    } else {
        const alerta = document.getElementById('alerta_roja');
        alerta.style.display = 'block';
        setTimeout(() => {
            alerta.style.display = 'none';
        }, 3000);
    }
});

document.getElementById('generate-card').addEventListener('click', function (e) {
    e.preventDefault();
    const cardNumber = generateRandomCardNumber();
    document.getElementById('card-number').value = cardNumber;
    document.getElementById('expiry-date').value = generateRandomExpiryDate();
    document.getElementById('cvv').value = generateRandomCVV();
});

function generateRandomCardNumber() {
    let cardNumber = '';
    for (let i = 0; i < 16; i++) {
        cardNumber += Math.floor(Math.random() * 10);
        if (i % 4 === 3 && i < 15) cardNumber += ' ';
    }
    return cardNumber;
}

function generateRandomExpiryDate() {
    const month = ('0' + Math.floor(Math.random() * 12 + 1)).slice(-2);
    const year = ('0' + Math.floor(Math.random() * 5 + 24)).slice(-2);
    return `${month}/${year}`;
}

function generateRandomCVV() {
    return ('000' + Math.floor(Math.random() * 1000)).slice(-3);
}

function validateCardDetails(cardNumber, expiryDate, cvv) {
    const cardNumberRegex = /^\d{4} \d{4} \d{4} \d{4}$/;
    const expiryDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
    const cvvRegex = /^\d{3}$/;

    return cardNumberRegex.test(cardNumber) && expiryDateRegex.test(expiryDate) && cvvRegex.test(cvv);
}
