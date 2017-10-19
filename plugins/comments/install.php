<?php

if (!is_dir($this->getDataPath())) {
    rex_dir::copy($this->getPath('data'), $this->getDataPath());
}