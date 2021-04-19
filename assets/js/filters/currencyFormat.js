module.exports = function (number) {
    // Make sure we have a number
    if (!(!Number.isNaN(parseFloat(number)) && isFinite(number))) return number;

    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    return formatter.format(number);
};