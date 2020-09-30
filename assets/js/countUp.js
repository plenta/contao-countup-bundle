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
            'useGrouping': (el.dataset.usegrouping === "true" ? true : false)
        };
        countUpItems[el.id] = new CountUp(el.id, el.dataset.endval, options);
    });

    function destroyCountUp(elID)
    {
        delete countUpItems.elID;
    }

    var latestKnownScrollY = 0;
    var ticking = false;

    function onScroll()
    {
        latestKnownScrollY = window.scrollY;
        requestTick();
    }

    function requestTick()
    {
        if (!ticking) {
            requestAnimationFrame(update);
        }
        ticking = true;
    }

    function update()
    {
        ticking = false;

        Array.prototype.forEach.call(elements, function (el,i) {
            if (true === isInViewport(el)) {
                countUpItems[el.id].start(destroyCountUp(el.id));
            }
        });
    }

    requestAnimationFrame(update);
    window.addEventListener('scroll', onScroll, false);

    function isInViewport(el)
    {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)

        );
    }
})();