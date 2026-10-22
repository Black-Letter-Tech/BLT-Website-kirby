<?php

$mediaIndex = site()->mediaIndex()->isTrue() ? 'site.index(true).images' : 'model.images';

return [
    'type' => 'files',
    'multiple' => false,
    'uploads' => 'image',
    'query' => $mediaIndex,
    'info' => '{{ file.dimensions }} {{ file.niceSize }}',
];