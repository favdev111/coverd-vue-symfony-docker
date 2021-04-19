require('moment-timezone');

module.exports = function (date) {
    let d = moment(date).tz('Etc/UTC');
    if (!d.isValid(date)) return null;
    return d.format('MMMM, YYYY');
};