<?php

if (!class_exists('SensitiveParameter')) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    class SensitiveParameter {}
}
