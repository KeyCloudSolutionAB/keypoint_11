<?php

//fi
$models = Translation::model()->findAll();
$list = CHtml::listData($models, 'title', 'translation_fi');
return $list;
