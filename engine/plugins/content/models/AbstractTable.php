<?php

namespace content\models;

abstract class AbstractTable
{
    abstract public static function getFields();
    abstract public static function getEditFields();
    abstract public static function getPrimaryKey();
}
