const router = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js');
const config = require('../../public/js/fos_js_routes.json');
router.setRoutingData(config);

module.exports = router;