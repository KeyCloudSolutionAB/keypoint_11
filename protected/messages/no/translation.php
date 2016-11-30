<?php

//no
$models = Translation::model()->findAll();
$list = CHtml::listData($models, 'title', 'translation_no');
return $list;
