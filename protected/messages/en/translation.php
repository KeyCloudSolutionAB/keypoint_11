<?php

//en
$models = Translation::model()->findAll();
$list = CHtml::listData($models, 'title', 'translation_en');
return $list;
