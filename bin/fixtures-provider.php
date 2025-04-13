#!/usr/bin/env php
<?php

$filename = __DIR__ . '/../fixtures/makeup_data.json';

$fixtures = file_get_contents($filename);

return  json_decode($fixtures, false);
