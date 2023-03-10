/*jshint esversion: 6 */
'use strict';

import { CountUp } from 'countup.js';

(function () {
    var elements = document.querySelectorAll('.ce_plenta_countup .countUpValue');
    var countUpItems = {};

    const setCssClasses = (el, state) => {
        let parent = el.parentElement;

        switch (state) {
            case 'onInit':
                parent.classList.add('countup-init');
                break;
            case 'onDormant':
                parent.classList.add('countup-dormant');
                break;
            case 'onRunning':
                parent.classList.add('countup-running');
                parent.classList.remove('countup-dormant');
                break;
            case 'onFinished':
                parent.classList.add('countup-finished');
                parent.classList.remove('countup-dormant');
                parent.classList.remove('countup-running');
                break;
        }
    };

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
        setCssClasses(el, 'onInit');
    });

    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 1.0
    };

    const callback = function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setCssClasses(entry.target, 'onRunning');

                countUpItems[entry.target.id].start(() => {
                    setCssClasses(entry.target, 'onFinished');
                    destroyCountUp(entry.target);
                });
            } else {
                if (false === entry.target.parentElement.classList.contains('countup-running') || false === entry.target.parentElement.classList.contains('countup-finished')) {
                    setCssClasses(entry.target, 'onDormant');
                }
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