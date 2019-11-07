<?php

namespace mg\fields;

use mg\core\ConstructField;

class Fizfield extends ConstructField {

    function __construct($value, $name) {
        $option = array(
            'fields' => array(
                'date' => array('type' => 'fdate', 'name' => 'date', 'title' => 'Дата'),
                'weight' => array('type' => 'numberint', 'name' => 'weight', 'title' => 'Вес'),
                'height' => array('type' => 'numberint', 'name' => 'height', 'title' => 'Высота в холке. В см.'),
                'height2' => array('type' => 'numberint', 'name' => 'height2', 'title' => 'Высота в крестце. В см.'),
                'length' => array('type' => 'numberint', 'name' => 'length', 'title' => 'Длина предплечья. В см.'),
                'length2' => array('type' => 'numberint', 'name' => 'length2', 'title' => 'Длина пясти. В см.'),
                'acidity' => array('type' => 'numberint', 'name' => 'acidity', 'title' => 'У козла обхват семенников. В см.'),
                'girth' => array('type' => 'numberint', 'name' => 'girth', 'title' => 'Вода')
            ),
            'add' => 'Добавить запись',
            'modal' => 'Данные',
            'table' => 'Физические характеристики',
            'modal_btn' => 'Посмотреть данные '
        );
        parent::__construct($value, $name, $option);
    }

    public function getFieldTitle() {

        return 'Физические характеристики';
    }

}
