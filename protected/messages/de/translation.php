<?php

//de
$models = Translation::model()->findAll();
$list = CHtml::listData($models, 'title', 'translation_de');
return $list;
