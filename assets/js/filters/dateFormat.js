require('moment');

module.exports = function (date) {
    let d = moment(date, 'Etc/UTC');
    if (!d.isValid(date)) return null;
    return d.format('MM/DD/YYYY');
};