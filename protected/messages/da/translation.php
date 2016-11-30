<?php

//da
$models = Translation::model()->findAll();
$list = CHtml::listData($models, 'title', 'translation_da');
return $list;
