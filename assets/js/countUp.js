/*jshint esversion: 6 */
'use strict';

import { CountUp } from 'countup.js';

(function () {
    var elements = document.querySelectorAll('.ce_plenta_countup .countUpValue');
    var countUpItems = {};

    Array.prototype.forEach.call(elements, function (el,i) {
        var options = {
            'duration': el.dataset.duration,
            'startVal': el.dataset.startval,
            'decimalPlaces': el.dataset.decimalplaces,
            'decimal': el.dataset.decimal,
            'separator': el.dataset.separator,
            'useGrouping': (el.dataset.usegrouping === "true" ? true : false),
            'useEasing': (el.dataset.useeasing === "true" ? true : false)
        };
        countUpItems[el.id] = new CountUp(el.id, el.dataset.endval, options);
    });

    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 1.0
    };

    const callback = function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUpItems[entry.target.id].start(destroyCountUp(entry.target));
            }
        });
    };

    let observer = new IntersectionObserver(callback, options);

    Array.prototype.forEach.call(elements, function (el,i) {
        observer.observe(el);
    });

    function destroyCountUp(el)
    {
        delete countUpItems[el.id];
        observer.unobserve(el);
    }
})();