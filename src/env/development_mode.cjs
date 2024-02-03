const {glob} = require('glob');
var fs = require('fs');
// import {glob} from 'glob';
// import fs from 'fs';



glob("wp-review-manager.php", {}, function(err, files) {
    if (err) {
        console.error(err);
        return;
    }

    files.forEach(function(item, index, array) {
        var data = fs.readFileSync(item, 'utf8');
        var mapObj = {
            WP_REVIEW_MANAGER_PRODUCTION: "WP_REVIEW_MANAGER_DEVELOPMENT"
        };

        var result = data.replace(/WP_REVIEW_MANAGER_PRODUCTION/gi, function(matched) {
            return mapObj[matched];
        });

        fs.writeFile(item, result, 'utf8', function (err) {
            if (err) {
                console.error(err);
                return;
            }
            console.log('✅ Development asset enqueued!');
        });
    });
});
