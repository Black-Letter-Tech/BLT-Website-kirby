<?php

// Kirby 5 merges the site controller into every template controller,
// so the contact form handling in site.php already runs for this
// template. The copy this file used to hold would run the handler a
// second time and send every submission twice.
return function () {
    return [];
};
