const {glob} = require('glob');
const fs = require('fs');

const newFiles = glob(['wp-review-manager.php'])
newFiles.then(function (files) {
    files.forEach(function(item, index, array) {
        const data = fs.readFileSync(item, 'utf8');
        const mapObj = {
            WP_REVIEW_MANAGER_DEVELOPMENT: "WP_REVIEW_MANAGER_PRODUCTION"
        };
        const result = data.replace(/WP_REVIEW_MANAGER_DEVELOPMENT/gi, function (matched) {
            return mapObj[matched];
        });
        fs.writeFile(item, result, 'utf8', function (err) {
        if (err) return console.log(err);
    });
    console.log('✅  Production asset enqueued!');
});
});