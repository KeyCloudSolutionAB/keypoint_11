<?php

//sv
$models = Translation::model()->findAll();
$list = CHtml::listData($models, 'title', 'translation_sv');
return $list;
