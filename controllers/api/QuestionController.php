<?php

namespace app\controllers\api;

class QuestionController extends \yii\rest\ActiveController
{
    use CorsUtil;
    public $modelClass = 'app\models\Question';
}
