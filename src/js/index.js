import FormValidator from './FormValidator/FormValidator.js';
import DomActions from './DomActions.js';
import GoogleMap from './GoogleMap.js';
import EditorsConnector from './EditorsConnector.js';
import ChartsConnector from './ChartsConnector.js';

(function () {
    if (window.NodeList && !NodeList.prototype.forEach) {
        NodeList.prototype.forEach = function (callback, thisArg) {
            var thisArg = thisArg || window;
            for (var i = 0; i < this.length; i++) {
                callback.call(thisArg, this[i], i, this);
            }
        };
    }
}());

new FormValidator();
new DomActions();
new GoogleMap();
new EditorsConnector();
new ChartsConnector();

