var glob = require('glob');
var fs = require('fs');

// For entry file selection
glob("wp-review-manager.php", function(err, files) {
        files.forEach(function(item, index, array) {
        var data = fs.readFileSync(item, 'utf8');
        var mapObj = {
            WP_REVIEW_MANAGER_PRODUCTION : "WP_REVIEW_MANAGER_DEVELOPMENT"
        };
        var result = data.replace(/WP_REVIEW_MANAGER_PRODUCTION/gi, function(matched){
            return mapObj[matched];
        });
        fs.writeFile(item, result, 'utf8', function (err) {
            if (err) return console.log(err);
        });
        console.log('✅  Production asset enqueued!');
    });
});