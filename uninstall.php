<?php

if (is_dir($this->getDataPath())) {
    rex_dir::delete($this->getDataPath());
}