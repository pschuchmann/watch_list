<?php

/** @var rex_addon $this */

if (!rex::isBackend()) {
    rex_login::startSession();
}
