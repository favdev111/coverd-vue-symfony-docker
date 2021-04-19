module.exports = {
    "moduleFileExtensions": [
        "js",
        "json",
        "vue"
    ],
    "transform": {
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest",
        ".*\\.(vue)$": "vue-jest"
    },
    "roots": [
        // Only look for tests in `assets/js`
        "<rootDir>/assets/js"
    ],
    "snapshotSerializers": ["jest-serializer-vue"]
};